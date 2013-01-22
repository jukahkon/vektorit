
var svSteps;
var svState = "idle"; // playback
var svCurrentImage = 0;
var svTimer = 0;

function showSreetViewImages(tripDate) {
    console.log("showSteetViewImages: " +tripDate);
    
    if (svTimer) {
        window.clearTimeout(svTimer);
    }
    
    svSteps = [];
    svState = "idle";
    
    var param = "op=getTripSteps&";
    param += "date=" + tripDate;
            
    $.get("trip_get.php", param, function(data) {
        $("#sv_date").text(formatDate(tripDate));        
        
        var steps = JSON.parse(data);        
        var lastStep = steps[steps.length-1];
        
        var x = Math.floor(steps.length / 10);
        if (x > 0) {
            // take every nth pic
            for (var i=0; i < steps.length; ) {
                svSteps.push(steps[i]);
                i += x;
            }
            
            // make sure last step is included
            if (svSteps[svSteps.length-1].distance != lastStep.distance) {
                svSteps.push(lastStep);
            }
            
        } else {
            svSteps = steps;
        }
        
        $("#sv_images").text(svSteps.length +"/" + svSteps.length);
        var distanceLeft = 109 - Math.floor(lastStep.distance);
        $("#toDest").text(distanceLeft.toString());
        var distanceNizza = 3500 - Math.floor(lastStep.distance);
        $("#toNizza").text(distanceNizza.toString());
        
        // console.log(JSON.stringify(svSteps));
        
        // Show last image
        loadAndShowImage(lastStep);        
    });    
}

function loadAndShowImage(step) {
    var image = '<img onclick="svPause()" style="display:none" class="street_view_image" src="http://maps.googleapis.com/maps/api/streetview?size=640x480&location='
                 + step.lat + "," + step.lng
                 + '&heading=' +step.heading + '&sensor=false">';

    $("#imageContainer").append(image);
    $("#imageContainer > img:last-child").imagesLoaded(showImage);
}

function showImage() {
    $("#imageContainer > img:last-child").fadeIn(500);
    
    if ($("#imageContainer > img").length === 3) {
        $("#imageContainer > img:first-child").remove();
    }
    
    if (svState == "playback") {
        $("#sv_images").text((svCurrentImage+1) + "/" + svSteps.length);
        
        var step = svSteps[svCurrentImage];
        console.log("Step: " +JSON.stringify(step));
        var distanceLeft = 109 - Math.floor(step.distance);
        $("#toDest").text(distanceLeft.toString());
        var distanceNizza = 3500 - Math.floor(step.distance);
        $("#toNizza").text(distanceNizza.toString());
        
        svTimer = window.setTimeout(showNextImage,3000);
    }
}

function svPlay() {
    console.log("svPlay");
    $("#playbackButton").fadeOut(500);
    svState = "playback";
    svCurrentImage = 0;
    loadAndShowImage(svSteps[svCurrentImage]);
}

function svPause() {
    console.log("svPause");
    if (svTimer) {
        window.clearTimeout(svTimer);
    }
    
    svState = "paused";
    $("#playbackButton").fadeIn(500);
}

function showNextImage() {
    svTimer = null;
    svCurrentImage++;
    if (svCurrentImage < svSteps.length) {
        loadAndShowImage(svSteps[svCurrentImage]);
    } else {
        $("#playbackButton").fadeIn(500);
        svState = "idle";
    }
}











