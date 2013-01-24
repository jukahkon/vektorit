
var teamData = [];
var currentPage = 1;
var membersPerPage = 10;
    
function updateTeamTable() {
    getTeamData(function() {
        console.log("Team data: " +teamData);
        
        if (teamData.length > 0) {
            $("#dataTable").show();
        }
        
        if (teamData.length > membersPerPage) {
            $("#pageSelector").show();
        }
        
        currentPage = 1;
        showTeamPage(currentPage);
        
        updatePageSelector(currentPage);
    });        
}

function getTeamData(callback) {
    console.log("getTeamData from server");
    $.get("team_get.php", "op=getTeamDistances", function(data) {
        teamData = JSON.parse(data);  
        callback();
    });
}

function showTeamPage(page) {
    var memberCount = teamData.length;
    var firstMember = (page - 1) * membersPerPage;
    var lastMember = firstMember + membersPerPage;
    if (lastMember > memberCount) {
        lastMember = memberCount;
    }

    $("#teamRows").empty();
    
    for (var i=firstMember; i < lastMember; i++) {
        var member = teamData[i];
        var distance = member.distance;
        if (!distance) {
            distance = "0.00";
        }
        
        if (member.id == userId) {
            var row = "<tr><td>" + (memberCount - i) + "</td><td>" + member.nickname + "</td><td id='team_table_user_td'>" + distance.replace(".",",") + "</td></tr>";
            $("#teamRows").append(row);            
        } else {
            var row = "<tr><td>" + (memberCount - i) + "</td><td>" + member.nickname + "</td><td>" + distance.replace(".",",") + "</td></tr>";
            $("#teamRows").append(row);
        }        
    }
}

function updatePageSelector(currentPage) {
    var memberCount = teamData.length;
    var pageCount = memberCount / membersPerPage;
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
    
    showTeamPage(currentPage);
    updatePageSelector(currentPage);
}




