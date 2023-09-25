<!DOCTYPE html>
<html>
<head>
    <% base_tag %>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    $MetaTags(false)

    <title>
        <% if $PageTitle %>$PageTitle<% else %>$Title &#124; $SiteConfig.CompanyName<% end_if %>
    </title>

    <% if $ClassName.ShortName = Blog %>
        <link rel="canonical" href="$AbsoluteLink"/>
    <% end_if %>
</head>
<body class="$ClassName.ShortName loading page-{$ID}<% if $ClassName.ShortName == HomePage %> front<% end_if %>">

<div id="my-page">
    <main>
        <section>
            <div class="container">
                $Layout
            </div>
        </section>
    </main>
</div>

$BetterNavigator

</body>
</html>
