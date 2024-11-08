<footer class="footer-wrapper footer-layout1" data-bg-src="<?php echo $asset; ?>assets/img/bg/footer_bg_1.jpg">
        <!-- <div class="container z-index-common">
            <div class="newsletter-wrap">
                <div class="newsletter-content">
                    <h2 class="sec-title">Subscribe for newsletter</h2>
                </div>
                <form class="newsletter-form">
                    <div class="form-group"><input class="form-control" type="email" placeholder="Email Address" required=""></div><button type="submit" class="th-btn shadow-1">Subscribe</button></form>
            </div>
        </div> -->
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo $link['logo']; ?>" alt="Mediax"></a></div>
                                <p class="about-text"><?php echo $link['brand']; ?></p>
                                <p class="footer-info"><i class="fal fa-location-dot"></i><?php echo $link['contact']['address']['office'].'<br>'.$link['contact']['address']['city'];?></p>
                                <p class="footer-info"><i class="fal fa-envelope"></i> <a href="mailto:<?php echo $link['contact']['email'][0]['email'];?>" class="info-box_link"><?php echo $link['contact']['email'][0]['email'];?></a></p>
                                <p class="footer-info"><i class="fal fa-phone"></i> <a href="tel:<?php echo $link['contact']['phone'][0]['phone'];?>" class="info-box_link"><?php echo $link['contact']['phone'][0]['phone'];?></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Navigasi</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <?php 
                                        if(!empty($link)){
                                        foreach($link['menu'] as $v){
                                        ?>
                                            <li><a href="<?php echo base_url().$v['news_url'];?>"><?php echo $v['news_title'];?></a></li>
                                        <?php 
                                        }
                                        }
                                    ?>  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Produk</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <?php 
                                    if(!empty($link['product_category'])){
                                        foreach($link['product_category'] as $v){
                                            echo "<li><a href='".site_url().$link['routing']['product'].'/'.$v['category_url']."'>".$v['category_name']."</a></li>"; 
                                        }
                                    }
                                    ?> 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="hide col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                <div class="recent-post">
                                    <div class="media-img"><a href="blog-details.html"><img src="<?php echo $asset; ?>assets/img/blog/recent-post-2-1.jpg" alt="Blog Image"></a></div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">How Business Is Taking Over & What to Do About It</a></h4>
                                        <div class="recent-post-meta"><a href="blog.html"><i class="fal fa-calendar"></i>21 Jun, 2024</a></div>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img"><a href="blog-details.html"><img src="<?php echo $asset; ?>assets/img/blog/recent-post-2-2.jpg" alt="Blog Image"></a></div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Health vs. Wealth Navigate Business in Medicine</a></h4>
                                        <div class="recent-post-meta"><a href="blog.html"><i class="fal fa-calendar"></i>22 Jun, 2024</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row gy-2 align-items-center">
                    <div class="col-md-7">
                        <p class="copyright-text">Copyright <i class="fal fa-copyright"></i> <?php echo date("Y");?> <a href="<?php echo base_url(); ?>"><?php echo $link['brand']; ?></a>. All Rights Reserved.</p>
                    </div>
                    <!-- <div class="col-md-5 text-center text-md-end">
                        <div class="th-social"><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a> <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a> <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a> <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a></div>
                    </div> -->
                </div>
            </div>
        </div>
    </footer>