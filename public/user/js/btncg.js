function animateBox() {
                    var box = document.getElementById('box');
                    var box2 = document.getElementById('box2');
                    box.style.opacity = '0';
                    setTimeout(function() {
                        box.style.display = 'none';
                        box2.style.display = 'block';
                        setTimeout(function() {
                            box2.style.opacity = '1';
                        }, 100);
                    }, 500);
}
