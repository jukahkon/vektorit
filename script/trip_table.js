
var trips = [];
var currentPage = 1;
var tripsPerPage = 7;
    
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
        
        updatePageSelector();
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
        var dateString = formatDate(trip.date);

        var row = "<tr date='" + trip.date + "'><td>" + (tripCount - i) + "</td><td>" + dateString + "</td><td>" + trip.distance.replace(".",",") + "</td></tr>";
        $("#tripRows").append(row);
    }
}

function previousTripPage() {
    if (currentPage > 1) {
        currentPage--;
        showTripPage(currentPage);
        updatePageSelector();
    }
}

function nextTripPage() {
    var pageCount = Math.ceil(trips.length / tripsPerPage);
    
    if (currentPage < pageCount) {
        currentPage++;
        showTripPage(currentPage);
        updatePageSelector();
    }
}

function updatePageSelector() {
    var pageCount = Math.ceil(trips.length / tripsPerPage);
    
    if (currentPage == 1) {
        $("#prevTripPage").addClass("disabled");
    } else {
        $("#prevTripPage").removeClass("disabled");
    }
    
    if (currentPage == pageCount) {
        $("#nextTripPage").addClass("disabled");
    } else {
        $("#nextTripPage").removeClass("disabled");
    }
}
