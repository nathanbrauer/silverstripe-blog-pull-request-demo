<div class="col-md-9">
    <h1>$Title for "$Query"</h1>
    <% if $SubTitle %><h2>$SubTitle</h2><% end_if %>

    <form $SearchForm.FormAttributes class="header-search mb-3" role="search">
        <div class="form-group">
            <input name="Search" aria-label="search" type="text" class="form-control" placeholder="Search...">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>


    <% if $Results %>
        <section>
        <% loop $Results %>
            <div class="mb-2">
                <h4>
                    <a href="$Link" title="Read more about &quot;{$Title}&quot;">
                        <% if $MenuTitle %>
                            $MenuTitle
                        <% else %>
                            $Title
                        <% end_if %>
                    </a>
                </h4>
                <% if $Content %>
                    <p class="mb-0">$Content.LimitWordCountXML</p>
                <% end_if %>
                <p class="mb-10"><a href="$Link" title="Learn more about &quot;{$Title}&quot;">Learn more</a></p>
            </div>
            <% if not $Last %><hr class="mb-2"><% end_if %>
        <% end_loop %>
        </section>

        <% with $Results %>
            <% include Pagination %>
        <% end_with %>
    <% else %>
        <p>Sorry, your search query did not return any results.</p>
    <% end_if %>
</div>
