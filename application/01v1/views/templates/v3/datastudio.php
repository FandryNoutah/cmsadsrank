<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lien data studio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Hauteur de l'écran */
}
        .phone {
            width: 360px;
            border: 1px solid #ccc;
            border-radius: 20px;
            background-color: white;
            justify-content: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
         
        }
        .header {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #f1f1f1;
            font-size: 14px;
           
        }
        .header div {
            cursor: pointer;
        }
        .header .active {
            border-bottom: 2px solid blue;
            font-weight: bold;
        }
        .content {
            padding: 16px;
            display: none;
            justify-content: center;
        }
        .content.active {
            display: block;
        }
        .youtube-content img {
            width: 100%;
            border-radius: 8px;
        }
        .gmail-content {
            background-color: #f9f9f9;
        }
        .gmail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            font-size: 14px;
            border-bottom: 1px solid #ccc;
        }
        .email-list {
            padding: 10px;
        }
        .email {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .email img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .email .email-info {
            flex-grow: 1;
        }
        .email .email-info h4 {
            margin: 0;
            font-size: 14px;
        }
        .email .email-info p {
            margin: 5px 0 0;
            font-size: 12px;
            color: gray;
        }
        .ad-description h3 {
            font-size: 14px;
            margin: 0;
        }
        .ad-description p {
            font-size: 12px;
            color: gray;
            margin: 5px 0;
        }
        .learn-more {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }
		.ad-container {
            padding: 16px;
        }
        .youtube-header {
            display: flex;
            align-items: center;
        }
        .youtube-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .youtube-header .channel-info {
            flex-grow: 1;
        }
        .youtube-header .channel-info h4 {
            margin: 0;
            font-size: 14px;
        }
        .youtube-header .channel-info span {
            color: gray;
            font-size: 12px;
        }
        .video-thumbnail {
            width: 100%;
            border-radius: 8px;
            margin: 10px 0;
        }
        .ad-description {
            margin: 10px 0;
        }
        .ad-description h3 {
            font-size: 14px;
            margin: 0;
        }
        .ad-description p {
            font-size: 12px;
            color: gray;
            margin: 5px 0;
        }
        .learn-more {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
        <div class="header">
            <div class="tab active" data-tab="youtube"><img src="https://upload.wikimedia.org/wikipedia/commons/4/42/YouTube_icon_%282013-2017%29.png" alt="YouTube" width="50px"></br>YouTube</div>
            <div class="tab" data-tab="gmail"><img src="https://upload.wikimedia.org/wikipedia/commons/4/42/YouTube_icon_%282013-2017%29.png" alt="YouTube"  width="50px"></br>Gmail</div>
        </div></br>
        <div class="container">
    <div class="phone">
        <!-- Header Navigation -->
       

        <!-- YouTube Content -->
        <div class="content youtube-content active">
             <div class="ad-container">
                
             <img src="<?php echo base_url(IMAGES_PATH."/youtube2.jpg"); ?>" style="width: 100%;">
            <div class="youtube-header">
            <?php  foreach($groupe_client as $G):?>
                
                
            </div>
            
            <img src="<?php echo $G['image_youtube1']; ?>" alt="Ad Thumbnail" class="video-thumbnail">

            <div class="youtube-header">
            <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" alt="Channel">
                <div class="channel-info">
                    <h4 style="margin-top: 20px;"><?php echo $G['titre1']; ?></h4>
                    <span><?php echo $G['descriptions1']; ?></span>
                    <span><b>Sponsored</b></span>
                </div>
                <span>⋮</span>
            </div>   
            <a href="#" class="learn-more">LEARN MORE</a>
            <img src="<?php echo base_url(IMAGES_PATH."/footeryoutube.jpg"); ?>" style="width: 100%;"> 
        </div>
        </div>

        <!-- Gmail Content -->
        <div class="content gmail-content">
            <div class="gmail-header">
                <span>Search in mail</span>
                <span>⋮</span>
            </div>
            <div class="email-list">
                <div class="email">
                    <img src="https://via.placeholder.com/40" alt="G&H Logo">
                    <div class="email-info">
                        <h4>Sponsored - Gary & Hanna</h4>
                        <p>Achetez des Montures Uniques</p>
                    </div>
                </div>
                <!-- Placeholder for other emails -->
                <div class="email">
                    <div class="email-info">
                        <h4>Email subject here</h4>
                        <p>Short description here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
            </div>
    <?php endforeach; ?>             
    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                // Add active class to the clicked tab and corresponding content
                tab.classList.add('active');
                const tabContent = document.querySelector(`.${tab.dataset.tab}-content`);
                tabContent.classList.add('active');
            });
        });
    </script>
</body>
</html>