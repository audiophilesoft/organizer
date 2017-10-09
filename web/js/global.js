function expandDescription(id) {
    let obj = document.getElementById(id);
    obj.style.display = (getComputedStyle(obj).display === 'none') ? 'block' : 'none';
}


function askDeletion(location) {
    if (confirm('Are you sure you want to delete this entry?')) {
        window.location = location;
    }
    return false;
}