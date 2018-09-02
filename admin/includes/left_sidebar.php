<!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="index.php" class="logo">
                            <span>
                                <img src="assets/images/logo.png" alt="" height="42">
                            </span>
                            <i>
                                <img src="assets/images/logo_sm.png" alt="" height="48">
                            </i>
                        </a>
                    </div>

                    <!-- User box -->
                    <div class="user-box">

                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <!--<li class="menu-title">Navigation</li>-->

                            <?php
                            if($_SESSION['level'] == Level::ADMIN )
                            {
                                ?>
                            <li>
                                <a href="index.php">
                                    <i class="fi-air-play"></i> <span> Dashboard </span>
                                </a>
                            </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['categories'] == TRUE)
                            {
                                ?>
                            <li>
                                <a href="javascript: void(0);"><i class="fi-layers"></i> <span> Categories </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="add_category.php">Add New Category</a></li>
                                    <li><a href="category_list.php">Category List</a></li>
                                </ul>
                            </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['loi'] == TRUE)
                            {
                                ?>
                            <li>
                                <a href="javascript: void(0);"><i class="fi-mail"></i><span> LOI </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="add_loi.php">Add New LOI</a></li>
                                    <li><a href="pending_loi.php">Pending LOI</a></li>
                                    <li><a href="accepted_loi.php">Accepted LOI</a></li>
                                    <li><a href="all_loi.php">All LOI</a></li>
                                </ul>
                            </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['sco'] == TRUE)
                            {
                                ?>
                            <li>
                                <a href="javascript: void(0);"><i class="fi-mail"></i><span> SCO </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="add_sco.php">Add New SCO</a></li>
                                    <li><a href="pending_sco.php">Pending SCO</a></li>
                                    <li><a href="accepted_sco.php">Accepted SCO</a></li>
                                    <li><a href="all_sco.php">All SCO</a></li>
                                </ul>
                            </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['spot_prices'])
                            {
                                ?>
                            <li>
                                <a href="javascript: void(0);"><i class="fa fa-dollar"></i> <span> Spot Prices </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="add_spot_item.php">Add New Item</a></li>
                                    <li><a href="spot_items.php">Manage Spot Items</a></li>
                                    <li><a href="edit_prices.php">Edit Spot Item Prices</a></li>
                                </ul>
                            </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['importers'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fi-mail"></i><span> Importers </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="pending_imports.php">Pending Offers</a></li>
                                        <li><a href="accepted_imports.php">Accepted Offers</a></li>
                                        <li><a href="all_imports.php">All Offers</a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['exporters'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fi-book"></i><span> Exporters </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="pending_exports.php">Pending Exports </a></li>
                                        <li><a href="accepted_exports.php">Accepted Exports </a></li>
                                        <li><a href="all_exports.php">All Offers</a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['sell_offers'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fi-book"></i><span> Sell Offers </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="pending_sell_offers.php">Pending Sell Offers </a></li>
                                        <li><a href="accepted_sell_offers.php">Accepted Sell Offers </a></li>
                                        <li><a href="all_sell_offers.php">All Offers</a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['buy_offers'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fi-book"></i><span> Buy Offers </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="pending_buy_offers.php">Pending Buy Offers </a></li>
                                        <li><a href="accepted_buy_offers.php">Accepted Buy Offers </a></li>
                                        <li><a href="all_buy_offers.php">All Offers</a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['products'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fa fa-shield"></i><span> Products </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="add_product.php"> Add New Product </a></li>
                                        <li><a href="product_list.php"> Product List </a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['newsletter'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fa fa-envelope"></i><span> NewLetter </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="add_email.php"> Add Newsletter Email </a></li>
                                        <li><a href="manage_mailing_list.php"> Manage Mailing List </a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['forum'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fa fa-envelope"></i><span> Manage Forum </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="all_topics.php"> All Forum Topics </a></li>
                                        <li><a href="flagged_topics.php"> Flagged Forum Topics </a></li>
                                        <li><a href="all_replies.php"> All Replies </a></li>
                                        <li><a href="flagged_replies.php"> Flagged Forum Replies </a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN)
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fa fa-users"></i><span> Manange Users </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="add_user.php">Add User </a></li>
                                        <li><a href="user_list.php"> Manage Users </a></li>
                                        <li><a href="admin_users.php"> Admin  Users </a></li>
                                    </ul>
                                </li>
                                <?php
                            }

                            if($_SESSION['level'] == Level::ADMIN || $_SESSION['quotation'])
                            {
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="fa fa-envelope"></i><span> Quotation </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="quotation_list.php"> All Quotations </a></li>
                                    </ul>
                                </li>
                                <?php
                            }
                             ?>

















                        </ul>

                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
