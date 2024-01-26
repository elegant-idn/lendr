
<!doctype html>
<title>{{trans('labels.site_on_maintenance')}}</title>
<style>
    body {
        font: 20px Helvetica, sans-serif;
        background-color: rgba(26, 32, 44, 1);
        text-align: center;
        padding: 150px;
    }
    article {
        display: block;
        text-align: left;
        width: 650px;
        margin: 0 auto;
    }
    article h1 {
        font-size: 50px;
    }
    article h1,
    article p {
        color: #a0aec0;
    }
</style>

<article>
    <h1>{{  trans('labels.We_will_be_back_soon') }}</h1>
    <p>{{ trans('labels.maintenance_message') }}</p>
</article>
