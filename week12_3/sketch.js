let playing = false;
let snowday;
let button;



function setup() {
//  createCanvas(600, 300);

    snowday = createVideo(['snowday2.mp4']);
  button = createButton('play');
  button.mousePressed(toggleVid);
    

}

function toggleVid() {
  if (playing) {
    snowday.pause();
      
    button.html('play');
  } else {
    snowday.loop();
    button.html('pause');
    
      
  }
  playing = !playing;
}





//function mouseClicked(){
//    
//    if (snowday.isPlaying) {
//    snowday.pause();
//  } else {
//    snowday.loop();
//  }
//    
//
//  };



//function draw() {
//  background(220);
//}