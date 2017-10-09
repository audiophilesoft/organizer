window.onload = function () {
    checkBackground();
};

function checkBackground(force_change = false)
{
    console.log('Checking BG...');
    let response = httpGet(force_change ? 'http://organizer.local/check_bg?force_change' : 'http://organizer.local/check_bg');
    console.log('Returned '+response);
    if (response === '1') {
        console.log('Computing new URL...');
        let bg = getComputedStyle(document.body).backgroundImage;
        let rand = getRandomStr(5);
        let new_bg = bg.slice(0, bg.length - 2) + '?' + rand + bg.slice(bg.length - 2, bg.length);
        console.log('New URL is '+new_bg);
        document.body.style.backgroundImage = new_bg;
        console.log('New URL was assigned to BG image');
        return null;
    }
    console.log('Nothing to update');
}

function httpGet(theUrl)
{
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", theUrl, false); // false for synchronous request
    xmlHttp.send(null);
    let res = xmlHttp.responseText;
    return res;
}


function getRandomStr(length)
{
    let chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let chars_num = chars.length;
    let string = '';
    for (let i = 0; i < length; i++) {
        string += chars.charAt(Math.floor(Math.random() * chars_num));
    }

    return string;
}