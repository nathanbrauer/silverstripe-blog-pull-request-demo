<div class="row">
    <div class="col-md-12">
        <% if $Content %>
        <div class="typography">
            $Content
        </div>
        <% end_if %>
        <% if $ElementalArea.Elements %>
            <div class="element-area main-element-area">
                $ElementalArea
            </div>
        <% end_if %>

        $Form
        $CommentsForm
    </div>
</div>
