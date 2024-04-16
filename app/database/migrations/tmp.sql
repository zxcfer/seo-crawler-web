Schema::table('website_availability_stats', function($table)
{
    $table->integer('website_id')->unsigned();
    $table->foreign('website_id')->references('id')->on('website')->onDelete('cascade');
});