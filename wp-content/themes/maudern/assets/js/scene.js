var initScene = function () {
    const modelCont = document.querySelector('.model-outer');

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera( 75, modelCont.offsetWidth / modelCont.offsetHeight, 0.1, 1000 );

    const renderer = new THREE.WebGLRenderer({alpha: true});
    renderer.setSize(modelCont.offsetWidth, modelCont.offsetHeight);

    const ambientLight = new THREE.AmbientLight( 0xffffff, 1.0 );
    scene.add( ambientLight );
  
    const mainLight = new THREE.DirectionalLight( 0xffffff, 0.5 );
    scene.add(mainLight);
    
    modelCont.querySelector('.clothing').appendChild( renderer.domElement );

    const controls = new THREE.OrbitControls( camera, renderer.domElement );

    camera.position.z = 5.5;
    camera.position.y = 4.2;

    const pos = new THREE.Vector3(0, 3.6, 0);
    camera.lookAt(pos);

    /*var globalPlane = new THREE.Plane( new THREE.Vector3( 1, 0, 0 ), 1 );
    renderer.clippingPlanes = [ globalPlane ];
    renderer.localClippingEnabled = true;*/

    var plane = new THREE.Plane(new THREE.Vector3(0, 0, 1),0.1);
    /*var planeH = new THREE.PlaneHelper(plane, 2, 0xffffff);
    scene.add(planeH);*/

    var mixer;
    
    var fbxLoader = new THREE.FBXLoader();
    fbxLoader.load('../../wp-content/themes/maudern/assets/models/female_anim_bind.fbx', function (object) {
        console.log(object);

        mixer = new THREE.AnimationMixer(object);
        console.log(object.animations);
        let action = mixer.clipAction(object.animations[0]);
        action.loop = THREE.LoopPingPong;
        action.play();

        object.scale.set(0.045, 0.045, 0.045);
        object.position.set(0, 0, 0);
        scene.add(object);
    });

    var loader = new THREE.GLTFLoader();
    var shoeL, shoeR;
                
    /*loader.load('../../wp-content/themes/maudern/assets/models/shoe.glb', function (gltf) {
        shoeL = gltf.scene;  // sword 3D object is loaded


        /*shoeL.traverse( function ( child ) {
            if (child.isMesh) {
                child.material.clippingPlanes = [plane];
                child.material.clipShadows = true;
                child.material.needsUpdate = true;
            }
        } );*/

        /*shoeL.scale.set(0.005, 0.005, 0.005);
        shoeL.position.z = -0.35;
        shoeL.position.x = -0.3;
        shoeL.position.y = 0;

        shoeL.rotation.y -= Math.PI/2;
        shoeL.needsUpdate = true;
        scene.add(shoeL);

        shoeR = shoeL.clone();
        shoeR.position.x = 0.3;
        const scale = new THREE.Vector3(1, 1, 1);
        scale.z *= -1;
        shoeR.scale.multiply(scale);
        scene.add(shoeR);
    });*/

    function animate() {
        requestAnimationFrame( animate );
        
        //if (shoe) shoe.rotation.y -= 0.01;

        //controls.update();
        if (mixer) mixer.update();

        renderer.render( scene, camera );
    }
    animate();
}


window.onload = function () {
    //this.initScene();

}