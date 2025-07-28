<?php if($groupe_client != NULL): ?> 
<?php //var_dump($groupe_client); die(); ?>
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
    height: 80vh; /* Hauteur de l'écran */
}
        .phone {
            width: 360px;
            border: 1px solid #ccc;
            border-radius: 20px;
            background-color: white;
            justify-content: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
         
        }
        .head1 {
                display: flex;
                justify-content: center; 

            
                margin: 0;
            }

            .header {
                width: 450px;
                display: flex;
                justify-content: space-around;
               
                background-color: #f9f9f9;
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
        .entete {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin: 10px;
    }

    .preview-container {
        display: flex;
        gap: 10px;
    }

    .preview-container img {
        display: block;
    }
    </style>
</head>

<body>
<div class="entete">
    <h4>Preview</h4>
    <div class="preview-container" >
        <img width="30" height= "30px" src="<?php echo base_url('assets/images/datastudio/telephone.png'); ?>" alt="WLB" title="WLB"/>
        <img width="30" height= "30px" style="" src="<?php echo base_url('assets/images/datastudio/ordinateur.png'); ?>" alt="WLB" title="WLB"/>
    </div>
</div>

<style>

</style>
    <div class="head1">
    <div class="header">
        <div class="tab active" data-tab="youtube" style="text-align: center"><img width="20" src="<?php echo base_url("assets/images/datastudio/youtube.png"); ?>" alt="WLB" title="WLB"/></br>YouTube</div>
        <div class="tab" data-tab="gmail" style="text-align: center"><img width="20" src="<?php echo base_url("assets/images/datastudio/gmail.png"); ?>" alt="WLB" title="WLB"/></br>Gmail</div>
        <!-- Ajout des nouveaux onglets -->
        <div class="tab" data-tab="recherche" style="text-align: center"><img width="20"  src="<?php echo base_url("assets/images/datastudio/google.png"); ?>" alt="WLB" title="WLB"/></br>Search</div>
        <div class="tab" data-tab="display" style="text-align: center"><img width="20" src="<?php echo base_url("assets/images/datastudio/Display.png"); ?>" alt="WLB" title="WLB"/></br>Display</div>
        <div class="tab" data-tab="discover" style="text-align: center"><img width="20" src="<?php echo base_url("assets/images/datastudio/Discover.png"); ?>" alt="WLB" title="WLB"/></br>Discover</div>
    </div>
    </div></br>
    <hr style="color: #9197B3; height: 1px !important; border: none; background-color: #9197B3;  margin-bottom: 20px;">

    <div class="container">
   
        <div class="phone">
            <?php ?>
          
            <div class="content youtube-content active">
            <p style="margin-top: -50px; text-align: center;">Video in-feed ad </p>
                <div class="ad-container">
                    <img src="<?php echo base_url(IMAGES_PATH."/youtube2.jpg"); ?>" style="width: 100%;">
                    <div class="youtube-header">
                        <?php //foreach($groupe_client as $G): ?>
                        </div>
                        <?php if (strpos($images[0]->image_url, 'http') === 0): ?>
                            <!-- Image externe -->
                            <img src="<?= $images[0]->image_url ?>"  alt="Image" style="width: 100%;object-fit: cover; margin-bottom: 15px;">
                        <?php else: ?>
                            <!-- Image locale (dans le dossier 'uploads') -->
                            <img src="<?= base_url($images[0]->image_url) ?>"   alt="Image" style="width: 100%;object-fit: cover; margin-bottom: 15px; ">
                        <?php endif; ?>
                        <div class="youtube-header">
                            <img src="<?php echo base_url($groupe_client[0]['favicon']); ?>" style="width: 50px; margin-left: 15px;" alt="Favicon">
                            <div class="channel-info">
                                <h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
                                <span><?php echo $groupe_client[0]['description_breve']; ?></span>
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
                <p style="font-size: 14px;">PROMOTIONS</p>
                <div class="email-list">
                    <div class="email">
                        <img src="<?php echo base_url($groupe_client[0]['favicon']); ?>" style="width: 50px; margin-left: 15px;" alt="Favicon">
                        <div class="email-info">
                            <h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
                            <p><?php echo $groupe_client[0]['description_breve']; ?></p>
                        </div>
                    </div>
                    <!-- Placeholder for other emails -->
                    <div class="email">
                        <div class="email-info">
                            <h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
                            <p><?php echo $groupe_client[0]['description_breve']; ?></p>
                        </div>
                    </div>
                    <img src="<?php echo base_url("assets/images/datastudio/suite_gmail.jpg"); ?>" alt="WLB" title="WLB"/>
                </div>
            </div>

            <!-- Recherche Content -->
            <div class="content recherche-content">
                <img src="<?php echo base_url("assets/images/datastudio/search.jpg"); ?>" alt="WLB" title="WLB"/>
                <div class="email-list">
                    <div class="email">
                        <img src="<?php echo base_url($groupe_client[0]['favicon']); ?>" style="width: 50px; margin-left: 15px;" alt="Favicon">
                        <div class="email-info">
                            <h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
                            <p><?php echo $groupe_client[0]['description_breve']; ?></p>
                        </div>
                    </div>
                    <!-- Placeholder for other emails -->
                    <div class="email">
                        <div class="email-info">
                            <h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
                            <p><?php echo $groupe_client[0]['descriptions1']; ?></p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center;">
    <img width="30" src="<?php echo base_url('assets/images/datastudio/telephone2.png'); ?>" alt="WLB" title="WLB"/>
    <h5 style="margin-top: 20px; margin-left: 10px;">Appeler le <?php echo $client[0]['numero_client']; ?></h5>
</div>


                </div>
            </div>

            <!-- Display Content -->
            <div class="content display-content">
            <h2 style="text-align: center">Display</h2>
            <img src="<?php echo base_url($groupe_client[0]['favicon']); ?>" style="width: 20px; margin-left: 15px;" alt="Favicon"><h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
            <p><?php echo $groupe_client[0]['description_breve']; ?></p>
            <?php if (strpos($images[0]->image_url, 'http') === 0): ?>
                            <!-- Image externe -->
                            <img src="<?= $images[0]->image_url ?>"  alt="Image" style="width: 100%;object-fit: cover; margin-bottom: 15px;">
                        <?php else: ?>
                            <!-- Image locale (dans le dossier 'uploads') -->
                            <img src="<?= base_url($images[0]->image_url) ?>"   alt="Image" style="width: 100%;object-fit: cover; margin-bottom: 15px; ">
                        <?php endif; ?>
                        <p><?php echo $groupe_client[0]['description_breve']; ?></p>
            </div>
     

            <!-- Discover Content -->
            <div class="content discover-content">
            <h2 style="text-align: center">Discover</h2>

            <?php if (strpos($images[0]->image_url, 'http') === 0): ?>
                            <!-- Image externe -->
                            <img src="<?= $images[0]->image_url ?>"  alt="Image" style="width: 100%;object-fit: cover; margin-bottom: 15px;">
                        <?php else: ?>
                            <!-- Image locale (dans le dossier 'uploads') -->
                            <img src="<?= base_url($images[0]->image_url) ?>"   alt="Image" style="width: 100%;object-fit: cover; margin-bottom: 15px; ">
                        <?php endif; ?>
                        <div class="youtube-header">
                            <img src="<?php echo base_url($groupe_client[0]['favicon']); ?>" style="width: 50px; margin-left: 15px;" alt="Favicon">
                            <div class="channel-info">
                                <h4 style="margin-top: 20px;"><?php echo $groupe_client[0]['titre1']; ?></h4>
                                <span><?php echo $groupe_client[0]['description_breve']; ?></span>
                               
                            </div>
                            <span>⋮</span>
                        </div>
                        <p><?php echo $groupe_client[0]['description_breve']; ?></p>
            </div>
        </div>
    </div>
       

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
<?php endif; ?>