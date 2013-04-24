this.screenshotPreview = function(){
        /* CONFIG */

                xOffset = 10;
                yOffset = 30;

                // these 2 variable determine popup's distance from the cursor
                // you might want to adjust to get the right result

        /* END CONFIG */
        $("a.screenshot").hover(function(e){
                this.t = this.title;
                this.title = "";
                var c = (this.t != "") ? "" + this.t : "";
                $("body").append("<p id='screenshot'><img src='"+ this.rel +"' alt='url preview' />"+ c +"</p>");
                $("#screenshot")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px")
                        .fadeIn("fast");
    },
        function(){
                this.title = this.t;
                $("#screenshot").remove();
    });
        $("a.screenshot").mousemove(function(e){
                $("#screenshot")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px");
        });
};
this.imagePreview = function(){
        /* CONFIG */

                xOffset = 10;
                yOffset = 30;

                // these 2 variable determine popup's distance from the cursor
                // you might want to adjust to get the right result

        /* END CONFIG */
        $("a.preview").hover(function(e){
        	
	        	$("a.preview").click(function(l){
	        		l.preventDefault();	
	        	});
	        	
                this.t = this.title;
                this.title = "";
                var c = (this.t != "") ? "" + this.t : "";
                $("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");
                $("#preview")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px")
                        .fadeIn("fast");
    },
        function(){
                this.title = this.t;
                $("#preview").remove();
    });
        $("a.preview").mousemove(function(e){
                $("#preview")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px");
        });
};
this.tooltip = function(){
        /* CONFIG */
                xOffset = 10;
                yOffset = 20;
                // these 2 variable determine popup's distance from the cursor
                // you might want to adjust to get the right result
        /* END CONFIG */
        $("a.tooltip").hover(function(e){
                this.t = this.title;
                this.title = "";
                $("body").append("<p id='tooltip'>"+ this.t +"</p>");
                $("#tooltip")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px")
                        .fadeIn("fast");
    },
        function(){
                this.title = this.t;
                $("#tooltip").remove();
    });
        $("a.tooltip").mousemove(function(e){
                $("#tooltip")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px");
        });
};