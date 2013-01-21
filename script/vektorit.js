
function logout () {
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', 'admin.php?op=logout');
    form.style.display = 'hidden';
    document.body.appendChild(form)
    form.submit();
}

function handleTripSubmit() {
    var value = $('#distanceInput').val().replace(",",".");
    if (!value) {
        value = "0";
    }
    var distance = parseFloat(value);
    if (isNaN(distance)) {
        return false;
    }

    distance = distance.toFixed(2);            
    var params = "date=" + $('#alt_date').val();
    params += "&distance=" + distance.toString();            
    console.log("Handle trip submit: " + params);

    $.post("trip_post.php", params, function(status) {
        if (status=="ok") {
            updateTripTable();
            updateStatusDisplay();
        }
    });

    return false;    
}


