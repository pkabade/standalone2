if(location.hostname == 'localhost')
{
    site_url = 'http://localhost/restclient/';
}
else
{
    site_url = __HOST__+'/';
}

$(document).ready(function (){
	$("ul.thumb li").hover(function() {
		$(this).css({'z-index' : '10'}); /*Add a higher z-index value so this image stays on top*/ 
		$(this).closest('ul').css('overflow-x','visible');
		$(this).closest('ul').css('overflow-y','scroll');
		$(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
			.animate({
				marginTop: '-72px', /* The next 4 lines will vertically align this image */ 
				marginLeft: '-100px',
				top: '50%',
				left: '50%',
				width: '180px', /* Set new width */
				height: '125px', /* Set new height */
				padding: '5px'
			}, 200); /* this value of "200" is the speed of how fast/slow this hover animates */

		} , function() {
		$(this).css({'z-index' : '0'}); /* Set z-index back to 0 */
		$(this).closest('ul').css('overflow-x','hidden');
		$(this).closest('ul').css('overflow-y','scroll');
		$(this).find('img').removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
			.animate({
				marginTop: '0', /* Set alignment back to default */
				marginLeft: '0',
				top: '0',
				left: '0',
				width: '116px', /* Set width back to default */
				height: '87px', /* Set height back to default */
				padding: '5px'
			}, 400);
	});
	
	/*
	 *Modified By:Sunny Patwa
	 *URL: http://www.(standalone).com/gallery 
	 *used to show a big image on click of thumbnail
	 */
	$("ul.thumb li img").click(function(){
		$('#big_image img').attr('src',$(this).attr('src'));
		$('#big_image img').attr('title',$(this).attr('title'));
	});
});

function days_between(date1, date2) {

    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24;

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();

    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);

    // Convert back to days and return
    return Math.round(difference_ms/ONE_DAY);

}

function day_of_week(date){

	return date.getDay();
}

