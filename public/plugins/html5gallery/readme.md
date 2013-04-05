Four Steps to Insert the Gallery to Your Web Page

1. Unzip the downloaded file, copy or upload the folder html5gallery to your web server

2. Reference the file html5gallery.js which is in the folder html5gallery before the </head> of your web page

    <script type="text/javascript" src="html5gallery/html5gallery.js"></script>
3. Add a div with class html5gallery to your web page where you want to display the Gallery. Define the size of the Gallery with HTML5 tag data-width and data-height. Specify the Skin with tag data-skin. There are 4 skins to choose from: darkness, light, vertical and horizontal. To hide all images before the Gallery is loaded, set the div's style to style="display:none;"

    <div style="display:none;" class="html5gallery" data-skin="horizontal" data-width="480" data-height="272">
    </div>
4. Add images and videos to this div to make a Gallery. The thumbnail is specified in the img tag, the full size image is defined in href attribute of the surrounded a tag. The title is defined in alt attribute of img tag.

    <div style="display:none;" class="html5gallery" data-skin="horizontal" data-width="480" data-height="272">
	    
       <!-- Add images to Gallery -->
       <a href="images/Tulip_large.jpg"><img src="images/Tulip_small.jpg" alt="Tulips"></a>
       <a href="images/Swan_large.jpg"><img src="images/Swan_small.jpg" alt="Swan on Lake"></a>

       <!-- Add videos to Gallery -->
       <a href="images/Big_Buck_Bunny.mp4"><img src="images/Big_Buck_Bunny.jpg" alt="Big Buck Bunny, Copyright Blender Foundation"></a>
       
       <!-- Add Youtube video to Gallery -->
       <a href="http://www.youtube.com/embed/YE7VzlLtp-4"><img src="http://img.youtube.com/vi/YE7VzlLtp-4/2.jpg" alt="Youtube Video"></a>
       
       <!-- Add Vimeo video to Gallery -->
       <a href="http://player.vimeo.com/video/1084537?title=0&amp;byline=0&amp;portrait=0"><img src="images/Big_Buck_Bunny.jpg" alt="Vimeo Video"></a>
    
    </div>
5. For more options, view http://html5box.com/html5gallery/install.php