<?php

namespace Modules\BookMark\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\BookMark\Entities\BookMark;
use Modules\CommentSystem\Entities\CommentSystem;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\Users\Entities\Users;

class BookMarkController extends Controller
{
    /**
     * Check Bookmark
     * @api /api/bookmark
     * @Method GET
     **/
    public function check(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Bookmark = BookMark::where('uid', $User)->where('object_id', $request->id)->where('type', $request->type)->first();

        if ($Bookmark) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Bookmark = BookMark::where('uid', $User)->where('object_id', $request->id)->where('type', $request->type)->first();

        if ($Bookmark) {
            $Bookmark->delete();
        } else {
            $BookMarkData = [];
            $BookMarkData['uid'] = $User;
            $BookMarkData['object_id'] = $request->id;
            $BookMarkData['type'] = $request->type;
            BookMark::create($BookMarkData);
        }
    }

    /**
     * Get Bookmarks
     * @api /api/bookmark
     * @Method GET
     **/
    public
    function show()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $BookmarkCompany = BookMark::where('uid', $User)->where('type', 'company')->select('object_id')->get();
        $BookmarkResume = BookMark::where('uid', $User)->where('type', 'resume')->select('object_id')->get();
        $BookmarkBlog = BookMark::where('uid', $User)->where('type', 'blog')->select('object_id')->get();

        $Resume = [];
        $Companies = [];
        $Blog = [];

        if ($BookmarkResume) {
            $ResumesIDs = [];
            foreach ($BookmarkResume as $item) {
                array_push($ResumesIDs, $item->object_id);
            }

            $Resume = ResumeManager::whereIn('id', $ResumesIDs ?  $ResumesIDs : [])->with(
                [
//                    'skill_tbl' => function ($query) {
//                        $query->addSelect('id', 'title');
//                    },
                    'user_tbl' => function ($query) {
                        $query->select('id', 'full_name', 'province', 'city');
                    },
                ]
            )->select('id', 'uid', 'job_position', 'level')->orderBy('created_at', 'desc')->get();

            foreach ($Resume as $key => $item) {
                $ResumeIntroducer = ResumeIntroducer::where('resume_id', $item->id)->orderBy('id', 'desc')->first();
                $Resume[$key]['expertise'] = $ResumeIntroducer->expertise;
                $Resume[$key]['personality'] = $ResumeIntroducer->personality;
                $Resume[$key]['experience'] = $ResumeIntroducer->experience;
                $Resume[$key]['software'] = $ResumeIntroducer->software;
                $Resume[$key]['organizational_behavior'] = $ResumeIntroducer->organizational_behavior;
                $Resume[$key]['passion'] = $ResumeIntroducer->passion;
                $Resume[$key]['salary_rate'] = $ResumeIntroducer->salary_rate;
                $Resume[$key]['confidence'] = HomeController::CheckConfidence($item->id);
                $Resume[$key]['bg_level'] = HomeController::BackgroundLevel($item->level);
                $Resume[$key]['province'] = HomeController::selectState('number', $item->user_tbl->province);
                $Resume[$key]['city'] = $item->user_tbl->city;
                $Resume[$key]['avatar'] = HomeController::AvatarGenerate(HomeController::GetUserData($item->uid, 'gender_org'));
                $Resume[$key]['percentage'] = HomeController::CheckResumePercentage($item->id);
            }
            if (count($Resume)) {
                foreach ($Resume as $key => $item) {
                    $Resume[$key]['user_tbl']['full_name'] = HomeController::Censor($item->user_tbl->full_name);
//                    unset($Resume[$key]['skill_tbl']['id']);
//                    unset($Resume[$key]['user_tbl']['id']);
                }
            }
        }

        if ($BookmarkCompany) {
            $CompaniesIDs = [];
            foreach ($BookmarkCompany as $item) {
                array_push($CompaniesIDs, $item->object_id);
            }

            $Companies = Users::whereIn('id', $CompaniesIDs ?  $CompaniesIDs : [])->select('id', 'avatar', 'company_name_fa', 'company_name_en', 'company_activity', 'province', 'city')->orderBy('created_at', 'desc')->get();

            foreach ($Companies as $key => $item) {
                $Companies[$key]['avatar'] = HomeController::GetAvatar('92', '246', $item->avatar);
                $Companies[$key]['province'] = HomeController::selectState('number', $item->province);
                if ($item->company_activity && $item->company_activity != 'null') {
                    $Companies[$key]['company_activity'] = HomeController::GetCompanyCategory(json_decode($item->company_activity)[0]) ? HomeController::GetCompanyCategory(json_decode($item->company_activity)[0])->title : 'مشحص نشده';
                } else {
                    $Companies[$key]['company_activity'] = 'مشحص نشده است';
                }
            }
        }

        if ($BookmarkBlog) {
            $BlogIDs = [];
            foreach ($BookmarkBlog as $item) {
                array_push($BlogIDs, $item->object_id);
            }

            $Blog = Blog::whereIn('id', $BlogIDs ?  $BlogIDs : [])->where('status', '=', 'published')->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat')->get();

            foreach ($Blog as $key => $item) {
                $Blog[$key]['thumbnailSRC'] = [];

                /* Thumbnail Path */
                if ($item->thumbnail_tbl) {
                    $Blog[$key]['thumbnailSRC'] = [
                        'path' => url('storage/' . $item->thumbnail_tbl->path . '467/' . $item->thumbnail_tbl->file_name),
                        'pathX2' => url('storage/' . $item->thumbnail_tbl->path . '934/' . $item->thumbnail_tbl->file_name)
                    ];
                }

                /* Cat Name */
                if ($item->cat) {
                    $Cat = BlogCategory::select('title', 'slug')->find(json_decode($item->cat, true)[0]);
                    $Blog[$key]['cat'] = $Cat;
                }

                /* Comment Count */
                $Blog[$key]['comment'] = CommentSystem::where('post_type', 'blog')->where('status', 'accepted')->where('post_id', $item->id)->get()->count();

                /* Description */
                $Blog[$key]['desc'] = HomeController::TruncateString($item->desc, 300, 300);
            }
        }
        return response()->json(['BookmarkCompany' => $Companies, 'BookmarkResume' => $Resume, 'BookmarkBlog' => $Blog]);
    }
}
