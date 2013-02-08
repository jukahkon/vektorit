
var teamData = [];
var currentPage = 1;
var membersPerPage = 10;
    
function updateTeamTable() {
    getTeamData(function() {
        console.log("Team data 2: " +JSON.stringify(teamData));
        
        if (teamData.length > 0) {
            $("#dataTable").show();
        }
        
        if (teamData.length > membersPerPage) {
            $("#pageSelector").show();
        }
        
        currentPage = 1;
        showMemberPage(currentPage);
        
        updatePageSelector();
    });        
}

function getTeamData(callback) {
    console.log("getTeamData from server");
    $.get("team_get.php", "op=getTeamDistances", function(data) {
        teamData = JSON.parse(data);  
        callback();
    });
}

function showMemberPage(page) {
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

function previousMemberPage() {
    if (currentPage > 1) {
        currentPage--;
        showMemberPage(currentPage);
        updatePageSelector();
    }
}

function nextMemberPage() {
    var pageCount = Math.ceil(teamData.length / membersPerPage);
    
    if (currentPage < pageCount) {
        currentPage++;
        showMemberPage(currentPage);
        updatePageSelector();
    }
}

function updatePageSelector() {
    var pageCount = Math.ceil(teamData.length / membersPerPage);
    
    if (currentPage == 1) {
        $("#prevMemberPage").addClass("disabled");
    } else {
        $("#prevMemberPage").removeClass("disabled");
    }
    
    if (currentPage == pageCount) {
        $("#nextMemberPage").addClass("disabled");
    } else {
        $("#nextMemberPage").removeClass("disabled");
    }
}



