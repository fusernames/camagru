navigator.getUserMedia = navigator.getUserMedia
  || navigator.webkitGetUserMedia
  || navigator.mozGetUserMedia
  || navigator.msGetUserMedia;
window.URL = window.URL
  || window.webkitURL;

var canvas, video;
navigator.getUserMedia({video: true}, function(localMediaStream) {
  video = document.querySelector('video');
  window.stream = localMediaStream;
  try {
    video.srcObject = localMediaStream;
  } catch (error) {
    video.src = window.URL.createObjectURL(localMediaStream);
  }
}, function(error) {
    console.log(error);
  }
);

function previewFilter(radio) {
  document.querySelector('#video_preview').src = 'public/filters/'+radio.value;
  document.querySelector('#snapshot_preview').src = 'public/filters/'+radio.value;
}

function takeSnapshot() {
  canvas = document.getElementById('my_canvas');
  var ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0,0, canvas.width, canvas.height);
  imageDataURL = canvas.toDataURL('image/png');
  document.getElementById('snapshot_div').style.display = 'block';
  document.getElementById('snapshot_img').src = imageDataURL;
  document.getElementById('snapshot_input').value = imageDataURL;
  document.getElementById('send_img').style.display = 'none';
}
