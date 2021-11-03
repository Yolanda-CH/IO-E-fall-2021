// this is a very simple sketch that demonstrates how to place a video cam image into a canvas 

let video;
let pose;
let skeleton;
//let song;



//  song = loadSound('assets_sounds_bubbles.mp3');


function setup(){
createCanvas(640, 480);
//song.loop();
    
noStroke();    
video = createCapture(VIDEO);
video.size(width,height);    

poseNet = ml5.poseNet(video, modelLoaded);
poseNet.on('pose', gotPoses) 
video.hide();    

    
    
}


//function mousePressed() {
//  if (song.isPlaying()) {
//    song.pause(); 
//    
//  } else {
//    song.play();
//  }
//}


function modelLoaded(){
    console.log("modelLoaded function has been called so this work!!!!");
    
};



function gotPoses(poses){
    //console.log(poses);
    if( poses.length > 0 ){
        pose = poses[0].pose;
        skeleton = poses[0].skeleton; 
    } 
    
} 





function draw(){
    
//background(0);
translate(video.width, 0);
scale(-1,1);
    
    
image(video, 0, 0, video.width, video.height);
//TRESHOLD 0 is white - 1 is black
//filter(THRESHOLD,1);    
//filter(GRAY);
//filter(OPAQUE);
//filter(INVERT);
//filter(POSTERIZE);
filter(BLUR,20);
//filter(ERODE);
//filter(DILATE);
//filter(OPAQUE);

    

    
    if(pose){
    //fill(255,0,0);
    //ellipse(pose.nose.x, pose.nose.y, 10);
    //image(img1, pose.leftWrist.x,pose.leftWrist.y , 150, 150);
    
    for(let i=0; i < pose.keypoints.length; i++){
    let x = pose.keypoints[i].position.x;
    let y = pose.keypoints[i].position.y;
    
    
    //console.log("keypoints");
    fill(random(10, 255));
   
    strokeWeight(10);
    stroke(random(50, 255));
    fill(0,250,0);    
    ellipse(x,y,40,40);
      //box(x,y,50);  
        
    for(let i = 0; i < skeleton.length; i++){
        let a = skeleton[i][0];
        let b = skeleton[i][1];
        strokeWeight(5);
        stroke(random(50, 255));
        line(a.position.x, a.position.y,b.position.x, b.position.y );
        }    
    }
}  
    
    
}