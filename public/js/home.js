var video = document.getElementById("hero_video");
var btn = document.getElementById("video_btn");

function toggleVideo() {
    if (video.paused) {
        video.play();
        btn.innerHTML = "&#9646;";
    } else {
        video.pause();
        btn.innerHTML = "&#9658;"; // &#9658; is a Play triangle symbol
    }
}
