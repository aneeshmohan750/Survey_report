


<iframe id="ifrm" src="https://app.powerbi.com/view?r=eyJrIjoiMzIzOTgzMDEtZTk4YS00MDQyLTlhYWUtYWUwYTFhMzdjNTUwIiwidCI6IjgwOThjMTMwLWNmZmMtNDg2Mi05OGI5LTc5ODE1NGFiZWEyZiIsImMiOjh9" width="100%" height="500" style="border:0">
</iframe>
<script>

$(document).ready(function(){
 middleHeight();	
	
});

function middleHeight() {
       var winHeight = $(window).height();
     var headHeight = $("#header").height();    
     var bodyMinHeight = winHeight-headHeight;
     $("#ifrm").css({ "height": bodyMinHeight-5});     
    } 
       
   
$( window ).resize(function() {
     middleHeight();
    });	
	
	
	</script>