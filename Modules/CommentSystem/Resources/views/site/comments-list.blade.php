<div class="comment-list">
    @forelse($Comments as $item)
        <div class="comment-item @isset($item->uid)@if(\Modules\Users\Entities\Users::find($item->uid)->first()->role != 'user'){{ 'admin-comment' }}@endif @endif @if(\Modules\CommentSystem\Entities\CommentSystem::where('parent_id', $item->id)->get()->first()){{ 'comment-is-parent' }}@endif">
            <div class="item-inner">
                <div class="heading">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="name-profile">
                                <span class="icon"><svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.1 10.65a.806.806 0 0 0-.2 0 2.724 2.724 0 0 1-2.633-2.725A2.73 2.73 0 0 1 10 5.192a2.73 2.73 0 0 1 .1 5.458ZM15.617 16.15A8.278 8.278 0 0 1 10 18.333a8.278 8.278 0 0 1-5.616-2.183c.083-.783.583-1.55 1.475-2.15 2.283-1.517 6.016-1.517 8.283 0 .892.6 1.392 1.367 1.475 2.15Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 18.333a8.333 8.333 0 1 0 0-16.666 8.333 8.333 0 0 0 0 16.666Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                <span class="name">{{ $item->name }}</span>
                            </div>
                        </div>
                        <div class="col-sm-3 right">
                            <div class="date-block">
                                <span class="icon"><svg width="18" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.667 1.667v2.5M12.333 1.667v2.5M1.917 7.575h14.167M16.5 7.083v7.084c0 2.5-1.25 4.166-4.167 4.166H5.667c-2.917 0-4.167-1.666-4.167-4.166V7.083c0-2.5 1.25-4.166 4.167-4.166h6.666c2.917 0 4.167 1.666 4.167 4.166Z" stroke="#BFBFBF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.08 11.417h.007M12.08 13.917h.007M8.996 11.417h.008M8.996 13.917h.008M5.912 11.417h.008M5.912 13.917h.008" stroke="#BFBFBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                <span class="date">{{ date_format($item->created_at,'Y/m/d') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment-text">{{ $item->message }}</div>
            </div>

            @forelse(\Modules\CommentSystem\Entities\CommentSystem::where('parent_id', $item->id)->where('status', 'accepted')->orderBy('created_at', 'desc')->get() as $item)
                <div class="comment-item comment-is-children @isset($item->uid)@if(\Modules\Users\Entities\Users::find($item->uid)->first()->role == 'admin'){{ 'admin-comment' }}@endif @endif @if(\Modules\CommentSystem\Entities\CommentSystem::where('parent_id', $item->id)->get()->first()){{ 'comment-is-parent' }}@endif">
                    <div class="item-inner">
                        <div class="heading">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="name-profile">
                                        <span class="icon"><svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.1 10.65a.806.806 0 0 0-.2 0 2.724 2.724 0 0 1-2.633-2.725A2.73 2.73 0 0 1 10 5.192a2.73 2.73 0 0 1 .1 5.458ZM15.617 16.15A8.278 8.278 0 0 1 10 18.333a8.278 8.278 0 0 1-5.616-2.183c.083-.783.583-1.55 1.475-2.15 2.283-1.517 6.016-1.517 8.283 0 .892.6 1.392 1.367 1.475 2.15Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 18.333a8.333 8.333 0 1 0 0-16.666 8.333 8.333 0 0 0 0 16.666Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                        <span class="name">{{ $item->name }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 right">
                                    <div class="date-block">
                                        <span class="icon"><svg width="18" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.667 1.667v2.5M12.333 1.667v2.5M1.917 7.575h14.167M16.5 7.083v7.084c0 2.5-1.25 4.166-4.167 4.166H5.667c-2.917 0-4.167-1.666-4.167-4.166V7.083c0-2.5 1.25-4.166 4.167-4.166h6.666c2.917 0 4.167 1.666 4.167 4.166Z" stroke="#BFBFBF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.08 11.417h.007M12.08 13.917h.007M8.996 11.417h.008M8.996 13.917h.008M5.912 11.417h.008M5.912 13.917h.008" stroke="#BFBFBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                        <span class="date">{{ date_format($item->created_at,'Y/m/d') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comment-text">{{ $item->message }}</div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    @empty
        <div class="no-comment">No comments have been posted for this content yet.</div>
    @endforelse
</div>
