
<script>
var Globals = <?php echo json_encode(array(
    'local' =>\App::getLocale(),
    'APP_ENV' => \App::environment(),
    'base_url' => \Config::get('app.url')
)); ?>;
</script>
