
var trips = [];
var currentPage = 1;
var tripsPerPage = 6;
    
function updateTripTable() {
    getTripData(function() {
        if (trips.length > 0) {
            $("#dataTable").show();
        }
        
        if (trips.length > tripsPerPage) {
            $("#pageSelector").show();
        }
        
        currentPage = 1;
        showTripPage(currentPage);
        
        updatePageSelector(currentPage);
    });        
}

function getTripData(callback) {
    console.log("getTripData from server");
    $.get("trip_get.php", "op=getTrips", function(data) {
        trips = JSON.parse(data);  
        callback();
    });
}

function showTripPage(page) {
    var tripCount = trips.length;
    var firstTrip = (currentPage - 1) * tripsPerPage;
    var lastTrip = firstTrip + tripsPerPage;
    if (lastTrip > tripCount) {
        lastTrip = tripCount;
    }

    $("#tripRows").empty();
    
    for (var i=firstTrip; i < lastTrip; i++) {
        var trip = trips[i];
        var date = new Date(trip.date);
        var dateString = date.getDate() + "." + (date.getMonth() + 1) + "." + date.getFullYear();

        var row = "<tr date='" + trip.date + "'><td>" + (tripCount - i) + "</td><td>" + dateString + "</td><td>" + trip.distance.replace(".",",") + "</td></tr>";
        $("#tripRows").append(row);
    }
}

function updatePageSelector(currentPage) {
    var tripCount = trips.length;
    var pageCount = tripCount / tripsPerPage;
    var firstPage = 1;
    var lastPage = Math.ceil(pageCount);
    
    $("#pageList").empty();
    
    $("#pageList").append("<li><a href='#' onclick='pageSelected(\"prev\"); return false;'>Edel.</a></li>");
    
    for (var i=firstPage; i <= lastPage; i++) {
        var row;
        if (i==currentPage) {
            row = "<li class='active'>"
        } else {
            row = "<li>";
        }
        
        row += "<a href='#' onclick='pageSelected(\"" + i + "\"); return false;'>" + i + "</a></li>";
        
        $("#pageList").append(row);
    }
    
    $("#pageList").append("<li><a href='#' onclick='pageSelected(\"next\"); return false;'>Seur.</a></li>");
}

function pageSelected(page) {
    console.log("pageSelected(): " +page);
    if (page=="prev") {
        if (currentPage > 1)
            currentPage--;
    } else if (page=="next") {
            currentPage++;
    } else {
        currentPage = parseInt(page);
    }
    
    showTripPage(currentPage);
    updatePageSelector(currentPage);
}