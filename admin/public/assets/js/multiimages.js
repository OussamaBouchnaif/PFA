    // script.js
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        document.getElementById('drop-area').classList.add('highlight');
    }
    
    function unhighlight(e) {
        document.getElementById('drop-area').classList.remove('highlight');
    }
    
    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
    
        handleFiles(files);
    }
    
    function handleFiles(files) {
        files = [...files];
        files.forEach(previewFile);
    }
    
    function previewFile(file) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = function() {
            let img = document.createElement('img');
            img.src = reader.result;
            document.getElementById('gallery').appendChild(createImageElement(img.src));
        };
    }
    
    function createImageElement(src) {
        let div = document.createElement('div');
        div.className = 'preview-image';
        let img = document.createElement('img');
        img.src = src;
        let button = document.createElement('button');
        button.className = 'delete-image';
        button.innerText = 'X';
        button.onclick = function() {
            this.parentNode.remove();
        };
        div.appendChild(img);
        div.appendChild(button);
        return div;
    }
    
    let dropArea = document.getElementById('drop-area');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    dropArea.addEventListener('drop', handleDrop, false);