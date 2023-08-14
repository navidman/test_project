<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\CommentSystem\Entities\CommentSystem;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\FileLibrary\Http\Controllers\FileLibraryController;
use Modules\Users\Entities\Users;

//use Modules\BannerManager\Entities\BannerManager;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $Blog = Blog::where('title', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $Blog = Blog::orderBy('created_at', 'desc')->paginate(20);
        }
        return view('blog::blog.index', compact('Blog'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $BlogCategory = BlogCategory::get()->all();
        return view('blog::blog.create', compact('BlogCategory'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BlogRequest $request)
    {
        $User = auth()->user();
        $BlogData = $request->all();
        $BlogData['thumbnail'] = FileLibraryController::upload($request->file('thumbnail'), 'image', 'blog/thumbnail', 'blog', array([266, 163, 'fit'], [532, 326, 'fit'], [830, null, 'resize'], [1660, null, 'resize']));
        $BlogData['author'] = $User->id;
        if ($request->cat) {
            $BlogData['cat'] = json_encode($request->cat);
        }
        if ($request->tag) {
            $BlogData['tag'] = json_encode($request->tag);
        }

        if ($request->featured) {
            $BlogData['featured'] = true;
        } else {
            $BlogData['featured'] = false;
        }

        if (Blog::create($BlogData)) {
            return redirect('dashboard/blog')->with('notification', [
                'class' => 'success',
                'message' => 'مطلب با موفقیت ثبت شد.'
            ]);
        } else {
            return redirect()->back()->with('notification', [
                'class' => 'alert',
                'message' => 'ذخیره اطلاعات با مشکل روبرو شد.'
            ]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($slug)
    {
        if (auth()->check() && auth()->user()->role == 'admin') {
            $Blog = Blog::where('slug', $slug)->orWhere('id', $slug)->first();
        } else {
            $Blog = Blog::where('slug', $slug)->where('status', 'published')->orWhere('id', $slug)->firstOrFail();
        }

        if ($Blog) {
            $BlogData['visited'] = $Blog->visited + 1;
            $Blog->update($BlogData);
            $Blog['thumbnailSRC'] = [];

            /* Thumbnail Path */
            if ($Blog->thumbnail_tbl) {
                $Blog['thumbnailSRC'] = [
                    'path' => url('storage/' . $Blog->thumbnail_tbl->path . '830/' . $Blog->thumbnail_tbl->file_name),
                    'pathX2' => url('storage/' . $Blog->thumbnail_tbl->path . '1660/' . $Blog->thumbnail_tbl->file_name)
                ];
            }

            $Author = Users::find($Blog->author);
            $Blog['author'] = [
                'full_name' => $Author->full_name,
            ];

            if ($Author->avatar) {
                $AuthorAvatar = FileLibrary::find($Author->avatar);
                if (isset($AuthorAvatar)) {
                    if ($AuthorAvatar->extension != 'svg') {
                        $Blog['author'] = [
                            'full_name' => $Author->full_name,
                            'avatar' => [
                                'path' => url('storage/' . $AuthorAvatar->path . '46/' . $AuthorAvatar->file_name),
                                'pathX2' => url('storage/' . $AuthorAvatar->path . '92/' . $AuthorAvatar->file_name)
                            ]
                        ];
                    } else {
                        $Blog['author'] = [
                            'full_name' => $Author->full_name,
                            'avatar' => [
                                'path' => url('storage/' . $AuthorAvatar->path . 'full/' . $AuthorAvatar->file_name),
                            ]
                        ];
                    }
                }
            }

            if ($Blog->tag) {
                $Blog['tag'] = json_decode($Blog->tag);
            }
        }

        if (isset($Blog->cat) && json_decode($Blog->cat, true)){
        $BlogCategory = BlogCategory::find(json_decode($Blog->cat, true)[0]);
        }else {
            $BlogCategory = [];
        }
        $RelatedPost = Blog::where('status', 'published')->get()->take(6);
        $Comments = CommentSystem::where('post_type', 'blog')->where('post_id', $Blog->id)->where('status', 'accepted')->orderBy('created_at', 'desc')->get();

        $Data = [
            'Blog' => $Blog,
            'BlogCategory' => $BlogCategory,
            'RelatedPost' => $RelatedPost,
            'Comments' => $Comments
        ];

        return response()->json($Data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Blog = Blog::find($id);
        $BlogCategory = BlogCategory::get()->all();


        $Data = [
            'Blog',
            'BlogCategory'
        ];
        return view('blog::blog.edit', compact($Data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BlogRequest $request, $id)
    {
        $Blog = Blog::find($id);
        $BlogData = $request->all();

        if ($request->tag) {
            $BlogData['tag'] = json_encode($request->tag);
        }

        if ($request->file('thumbnail')) {
            $BlogData['thumbnail'] = FileLibraryController::upload($request->file('thumbnail'), 'image', 'blog/thumbnail', 'blog', array([266, 163, 'fit'], [532, 326, 'fit'], [830, null, 'resize'], [1660, null, 'resize']));
        }

        if ($request->featured) {
            $BlogData['featured'] = true;
        } else {
            $BlogData['featured'] = false;
        }

        if ($request->cat) {
            $BlogData['cat'] = json_encode($request->cat);
        }

        if ($Blog->status == 'draft' && $request->status == 'published') {
            $BlogData['publish_at'] = date('Y-m-d H:i:s');
        }

        if ($Blog->update($BlogData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/blog')->with('notification', [
                'class' => 'danger',
                'message' => 'بروزرسانی با خطا روبرو شد'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        foreach ($request->delete_item as $key => $item) {
            Blog::where('id', $key)->delete();
        }

        return redirect('/dashboard/blog')->with('notification', [
            'class' => 'success',
            'message' => 'مطالب مورد نظر حذف شد'
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function show_list()
    {
        if (isset($_GET['search']) && $_GET['search'] || isset($_GET['cat']) && $_GET['cat']) {
            $Blog = Blog::where('title', 'like', '%' . $_GET['search'] . '%')->where('cat', 'like', '%' . $_GET['cat'] . '%')->where('status', '=', 'published')->orderBy('published_at', 'desc')->paginate(12)->onEachSide(1);
        } else {
            $Blog = Blog::where('status', '=', 'published')->orderBy('publish_at', 'desc')->paginate(12)->onEachSide(1);
        }

        $BlogCategory = BlogCategory::get()->all();

        $Data = [
            'Blog',
            'BlogCategory'
        ];

        return view('site.blog.blog', compact($Data));
    }

    public function getLastArticles($count)
    {
        $Blog = Blog::where('status', '=', 'published')->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'slug', 'cat')->get()->take($count);

        foreach ($Blog as $key => $item) {
            $Blog[$key]['thumbnailSRC'] = [];

            /* Thumbnail Path */
            if ($item->thumbnail_tbl) {
                $Blog[$key]['thumbnailSRC'] = [
                    'path' => url('storage/' . $item->thumbnail_tbl->path . '266/' . $item->thumbnail_tbl->file_name),
                    'pathX2' => url('storage/' . $item->thumbnail_tbl->path . '532/' . $item->thumbnail_tbl->file_name)
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
            $Blog[$key]['desc'] = HomeController::TruncateString($item->desc, 210, 210);
        }

        return response()->json($Blog);
    }

    public function EditorChoice($count)
    {
        $EditorChoiceCatID = BlogCategory::where('title', 'منتخب سردبیر')->first();
        $EditorChoice = null;
        if ($EditorChoiceCatID) {
            $EditorChoice = Blog::where('status', '=', 'published')->whereJsonContains('cat', $EditorChoiceCatID->id)->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat')->get()->take($count);
            foreach ($EditorChoice as $key => $item) {
                $EditorChoice[$key]['thumbnailSRC'] = [];

                /* Thumbnail Path */
                if ($item->thumbnail_tbl) {
                    $EditorChoice[$key]['thumbnailSRC'] = [
                        'path' => url('storage/' . $item->thumbnail_tbl->path . '266/' . $item->thumbnail_tbl->file_name),
                        'pathX2' => url('storage/' . $item->thumbnail_tbl->path . '532/' . $item->thumbnail_tbl->file_name)
                    ];
                }

                /* Cat Name */
                if ($item->cat) {
                    $Cat = BlogCategory::select('title', 'slug')->find(json_decode($item->cat, true)[0]);
                    $EditorChoice[$key]['cat'] = $Cat;
                }

                /* Comment Count */
                $EditorChoice[$key]['comment'] = CommentSystem::where('post_type', 'blog')->where('status', 'accepted')->where('post_id', $item->id)->get()->count();

                /* Description */
                $EditorChoice[$key]['desc'] = HomeController::TruncateString($item->desc, 250, 250);
            }
        }

        return response()->json($EditorChoice);
    }

    public function blog()
    {
        $Blog = Blog::where('status', '=', 'published')->where('featured', '!=', 1)->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat')->get()->take(3);

        foreach ($Blog as $key => $item) {
            $Blog[$key]['thumbnailSRC'] = [];

            /* Thumbnail Path */
            if ($item->thumbnail_tbl) {
                $Blog[$key]['thumbnailSRC'] = [
                    'path' => url('storage/' . $item->thumbnail_tbl->path . '266/' . $item->thumbnail_tbl->file_name),
                    'pathX2' => url('storage/' . $item->thumbnail_tbl->path . '532/' . $item->thumbnail_tbl->file_name)
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
            $Blog[$key]['desc'] = HomeController::TruncateString($item->desc, 250, 250);
        }

        /*
       * Featured Post
       * */
        $FeaturedPost = Blog::where('status', '=', 'published')->where('featured', 1)->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat', 'article_level')->get()->take(1);

        foreach ($FeaturedPost as $key => $item) {
            $FeaturedPost[$key]['thumbnailSRC'] = [];

            /* Thumbnail Path */
            if ($item->thumbnail_tbl) {
                $FeaturedPost[$key]['thumbnailSRC'] = [
                    'path' => url('storage/' . $item->thumbnail_tbl->path . '266/' . $item->thumbnail_tbl->file_name),
                    'pathX2' => url('storage/' . $item->thumbnail_tbl->path . '532/' . $item->thumbnail_tbl->file_name)
                ];
            }

            /* Cat Name */
            if ($item->cat) {
                $Cat = BlogCategory::select('title', 'slug')->find(json_decode($item->cat, true)[0]);
                $FeaturedPost[$key]['cat'] = $Cat;
            }

            /* Comment Count */
            $FeaturedPost[$key]['comment'] = CommentSystem::where('post_type', 'blog')->where('status', 'accepted')->where('post_id', $item->id)->get()->count();

            /* Description */
            $FeaturedPost[$key]['desc'] = HomeController::TruncateString($item->desc, 500, 500);
        }

        /*
         * More Post Blog
         * */
        $MorePostBlog = Blog::where('status', '=', 'published')->where('featured', '!=', 1)->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat')->skip(3)->cursorPaginate(3);

        /* Searched Post */
        if (isset($_GET['search']) || isset($_GET['cat'])) {
            $MorePostBlog = Blog::where('status', 'published')->where(
                function ($query) {
                    if (isset($_GET['search']) && $_GET['search']) {
                        $query->where('title', 'like', '%' . $_GET['search'] . '%');
                    }
                    if (isset($_GET['cat']) && $_GET['cat']) {
                        $query->whereJsonContains('cat', $_GET['cat']);
                    }
                })->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat')->paginate(15);
        }

        foreach ($MorePostBlog as $key => $item) {
            $MorePostBlog[$key]['thumbnailSRC'] = [];

            /* Thumbnail Path */
            if ($item->thumbnail_tbl) {
                $MorePostBlog[$key]['thumbnailSRC'] = [
                    'path' => url('storage/' . $item->thumbnail_tbl->path . '266/' . $item->thumbnail_tbl->file_name),
                    'pathX2' => url('storage/' . $item->thumbnail_tbl->path . '532/' . $item->thumbnail_tbl->file_name)
                ];
            }

            /* Cat Name */
            if ($item->cat) {
                $Cat = BlogCategory::select('title', 'slug')->find(json_decode($item->cat, true)[0]);
                $MorePostBlog[$key]['cat'] = $Cat;
            }

            /* Comment Count */
            $MorePostBlog[$key]['comment'] = CommentSystem::where('post_type', 'blog')->where('status', 'accepted')->where('post_id', $item->id)->get()->count();

            /* Description */
            $MorePostBlog[$key]['desc'] = HomeController::TruncateString($item->desc, 250, 250);
        }

        /* Get Popular Categories */
        $PopularCategories = BlogCategory::withCount('blog')->orderBy('blog_count', 'desc')->get()->take(5);

        foreach ($PopularCategories as $key => $item) {
            if ($item->blog_count == 0) {
                unset($PopularCategories[$key]);
            }
        }

        $Data = [
            'FirstPosts' => $Blog,
            'FeaturedPost' => $FeaturedPost,
            'MorePost' => $MorePostBlog,
            'PopularCategories' => $PopularCategories,
        ];

        return response()->json($Data);
    }

    public function GetCategory()
    {
        /* Get Category */
        $GetCategory = BlogCategory::select('id', 'title')->get()->all();

        return response()->json($GetCategory);
    }

    public function BlogCategory($slug)
    {
        $GetCategoryID = BlogCategory::where('slug', $slug)->select('id', 'title', 'slug')->first();
        $Blog = Blog::where('status', '=', 'published')->where('cat', $GetCategoryID->id)->orderBy('publish_at', 'desc')->select('id', 'title', 'desc', 'thumbnail', 'time_watch', 'slug', 'visited', 'cat')->paginate(9);
        foreach ($Blog as $key => $item) {
            $Blog[$key]['thumbnailSRC'] = HomeController::GetAvatar('266', '532', $item->thumbnail);

            $Blog[$key]['cat'] = $GetCategoryID;

            /* Comment Count */
            $Blog[$key]['comment'] = CommentSystem::where('post_type', 'blog')->where('status', 'accepted')->where('post_id', $item->id)->get()->count();

            /* Description */
            $Blog[$key]['desc'] = HomeController::TruncateString($item->desc, 250, 250);

            unset($Blog[$key]['thumbnail']);
        }

        return response()->json($Blog);
    }
}
