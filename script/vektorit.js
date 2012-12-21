
function logout () {
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', 'admin.php?op=logout');
    form.style.display = 'hidden';
    document.body.appendChild(form)
    form.submit();
}


