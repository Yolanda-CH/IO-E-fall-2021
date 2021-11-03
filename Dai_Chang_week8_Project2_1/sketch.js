let video;
let poseNet;
let pose;
let mic;

function setup() {
  createCanvas(640, 480);
  video = createCapture(VIDEO);
  video.size(width,height);
  video.hide();
  poseNet = ml5.poseNet(video, modelLoaded);
  poseNet.on('pose', gotPoses);
  
  mic = new p5.AudioIn();
  mic.start();
   
}

function gotPoses(poses){
  console.log(poses);
  if (poses.length > 0){
    pose = poses[0].pose;
    skeleton = poses[0].skeleton;
  }
}

function modelLoaded(){
  // console.log('poseNet ready');
  console.log("modelLoaded function has been called so this work!!!!");
}

function draw() {
  // image(video, 0, 0);
  image(video, 0, 0,width,height);
  filter(THRESHOLD,1); 
  
  
  if (pose){
    
    let eyeR = pose.rightEye;
    let eyeL = pose.leftEye;
    let d = dist(eyeR.x, eyeR.y, eyeL.x, eyeL.y);
    
    
    // fill(255,0,0);
    // ellipse(pose.nose.x, pose.nose.y, d);
    fill(13, 59, 102);
    ellipse(pose.rightWrist.x, pose.rightWrist.y, 32);
    ellipse(pose.leftWrist.x, pose.leftWrist.y, 32);
    
    for (let i = 0; i < pose.keypoints.length; i++){
      let x = pose.keypoints[i].position.x;
      let y = pose.keypoints[i].position.y;
      fill(255,0,0);
      ellipse(x,y,30,30);
      
      
      for(let i = 0; i < skeleton.length; i++){
        let a = skeleton[i][0];
        let b = skeleton[i][1];
        strokeWeight(2);
        stroke(255);
        line(a.position.x, a.position.y,b.position.x, b.position.y );
        } 
    }
    
  }
  
  let vol = mic.getLevel();
  fill(253, 250, 236);
  noStroke();
  
  
  let w2= map(vol, 0, 1.3, 0, width);
  ellipse(w2 + 25, height * 0.166, 50, 50);
  
  let w1= map(vol, 0, 0.4, 0, width);
  ellipse(w1 + 21, height * 0.332, 42, 42);
  
  let w3= map(vol, 0, 0.8, 0, width);
  ellipse(w3 + 17, height * 0.498, 34, 34);
  
  let w4= map(vol, 0, 0.2, 0, width);
  ellipse(w4 + 14, height * 0.664, 28, 28);
  
  let w5= map(vol, 0, 0.6, 0, width);
  ellipse(w5 + 10, height * 0.83, 20, 20);

  
  
  
  
  let w8= map(vol, 0, 0.2, width, 0);
  ellipse(w8 - 9, height * 0.142, 18, 18);
  
  let w9= map(vol, 0, 0.6, width, 0);
  ellipse(w9 - 11, height * 0.284, 22, 22);
  
  let w10= map(vol, 0, 0.3, width, 0);
  ellipse(w10 - 14, height * 0.426, 28, 28);
  
  let w11= map(vol, 0, 0.7, width, 0);
  ellipse(w11 - 18, height * 0.568, 36, 36);
  
  let w12= map(vol, 0, 1, width, 0);
  ellipse(w12 - 21, height * 0.710, 42, 42);
  
  let w13= map(vol, 0, 0.4, width, 0);
  ellipse(w13 - 24, height * 0.852, 48, 48);
  
}