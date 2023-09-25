<div class="row">
    <div class="col-md-12 px-0 article-landing">
        <div class="row">
            <div class="article-info">
                <div class="article-info__pre-title">Articles</div>
                <h1>$Title</h1>
            </div>

            <% if $Content %>
                <div class="typography">
                    $Content
                </div>
            <% end_if %>

            <div class="article-area">
                <div class="article-area__top">
                    <% if $SubTitle %><h2 class="article-info__subtitle">$SubTitle</h2><% end_if %>
                </div>
                <div class="element-area main-element-area clearfix">
                    $ElementalArea
                </div>
            </div>
        </div>
    </div>
</div>
