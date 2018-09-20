
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Simple Call to Action</title>
  <style type="text/css">
    /* /\/\/\/\/\/\/\/\/ CLIENT-SPECIFIC STYLES /\/\/\/\/\/\/\/\/ */
    #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" message */
    .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing */
    body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    td ul li {
      font-size: 16px;
    }
    /* /\/\/\/\/\/\/\/\/ RESET STYLES /\/\/\/\/\/\/\/\/ */
    body {margin: 0; padding: 0; min-width: 100%!important;}
    img{
      max-width:100%;
      border:0;
      line-height:100%;
      outline:none;
      text-decoration:none;
    }
    table{border-collapse:collapse !important;}
    .content {width: 100%; max-width: 600px;}
    .content img { height: auto; min-height: 1px; }

    #bodyCellFooter{margin:0; padding:0; width:100% !important;padding-top:39px;padding-bottom:15px;}

    #templateContainer{
      border: 1px solid #e2e2e2;
      border-radius: 4px;
      background-clip: padding-box;
      border-spacing: 0;
    }

    /**
    * @tab Page
    * @section heading 1
    * @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
    * @style heading 1
    */
    h1{
      color:#2e2e2e;
      display:block;
      font-family:Helvetica;
      font-size:26px;
      line-height:1.385em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }

    /**
    * @tab Page
    * @section heading 2
    * @tip Set the styling for all second-level headings in your emails.
    * @style heading 2
    */
    h2{
      color:#2e2e2e;
      display:block;
      font-family:Helvetica;
      font-size:22px;
      line-height:1.455em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }

    /**
    * @tab Page
    * @section heading 3
    * @tip Set the styling for all third-level headings in your emails.
    * @style heading 3
    */
    h3{
      color:#545454;
      display:block;
      font-family:Helvetica;
      font-size:18px;
      line-height:1.444em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }

    /**
    * @tab Page
    * @section heading 4
    * @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
    * @style heading 4
    */
    h4{
      color:#545454;
      display:block;
      font-family:Helvetica;
      font-size:14px;
      line-height:1.571em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }


    h5{
      color:#545454;
      display:block;
      font-family:Helvetica;
      font-size:13px;
      line-height:1.538em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }


    h6{
      color:#545454;
      display:block;
      font-family:Helvetica;
      font-size:12px;
      line-height:2.000em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }

    p {
      color:#545454;
      display:block;
      font-family:Helvetica;
      font-size:16px;
      line-height:1.500em;
      font-style:normal;
      font-weight:normal;
      letter-spacing:normal;
      margin-top:0;
      margin-right:0;
      margin-bottom:15px;
      margin-left:0;
      text-align:left;
    }

    .unSubContent a:visited { color: #a1a1a1; text-decoration:underline; font-weight:normal;}
    .unSubContent a:focus   { color: #a1a1a1; text-decoration:underline; font-weight:normal;}
    .unSubContent a:hover   { color: #a1a1a1; text-decoration:underline; font-weight:normal;}
    .unSubContent a:link   { color: #a1a1a1 ; text-decoration:underline; font-weight:normal;}
    .unSubContent a .yshortcuts   { color: #a1a1a1 ; text-decoration:underline; font-weight:normal;}

    .unSubContent h6 {
      color: #a1a1a1;
      font-size: 12px;
      line-height: 1.5em;
      margin-bottom: 0;
    }

    .bodyContent{
      color:#505050;
      font-family:Helvetica;
      font-size:14px;
      line-height:150%;
      padding-top:3.143em;
      padding-right:3.5em;
      padding-left:3.5em;
      padding-bottom:3.143em;
      text-align:left;
    }

    /**
    * @tab Body
    * @section body link
    * @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
    */
    a:visited { color: #3386e4; text-decoration:none;}
    a:focus   { color: #3386e4; text-decoration:none;}
    a:hover   { color: #3386e4; text-decoration:none;}
    a:link   { color: #3386e4 ; text-decoration:none;}
    a .yshortcuts   { color: #3386e4 ; text-decoration:none;}

    .bodyContent img{
      height:auto;
      max-width:498px;
    }

    /**
    * @tab Footer
    * @section footer link
    * @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
    */
    a.blue-btn {
      background: #5098ea;
      display: inline-block;
      color: #FFFFFF;
      border-top:10px solid #5098ea;
      border-bottom:10px solid #5098ea;
      border-left:20px solid #5098ea;
      border-right:20px solid #5098ea;
      text-decoration: none;
      font-size: 14px;
      margin-top: 1.0em;
      border-radius: 3px 3px 3px 3px;
      background-clip: padding-box;
    }


    @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
      body[yahoo] .hide {display: none!important;}
      body[yahoo] .buttonwrapper {background-color: transparent!important;}
      body[yahoo] .button {padding: 0px!important;}
      body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
      body[yahoo] .unsubscribe { font-size: 14px; display: block; margin-top: 0.714em; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important;}
    }
    /*@media only screen and (min-device-width: 601px) {
      .content {width: 600px !important;}
    }*/
    @media only screen and (max-width: 480px), screen and (max-device-width: 480px) {
      h1 {
        font-size:34px !important;
      }
      h2{
        font-size:30px !important;
      }
      h3{
        font-size:24px !important;
      }
      h4{
        font-size:18px !important;
      }
      h5{
        font-size:16px !important;
      }
      h6{
        font-size:14px !important;
      }
      p {
        font-size: 18px !important;
      }
      .bodyContent {
        padding: 6% 5% 6% 6% !important;
      }
      .bodyContent img {
        max-width: 100% !important;
      }
      #bodyCellFooter {padding-top: 20px !important;}
      .hide {display:none !important;}
    }
    .ii a[href] {color: inherit !important;}
    span > a, span > a[href] {color: inherit !important;}
    a > span, .ii a[href] > span {text-decoration: inherit !important;}
  </style>
</head>

<body yahoo bgcolor="#ffffff">
<table width="100%" bgcolor="#ffffff" border="0" cellpadding="10" cellspacing="0">
<tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
				<td align="center" valign="top">
						<!-- BEGIN BODY // -->
						<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainer">
							<tr>
								<td valign="top" class="bodyContent" mc:edit="body_content">
                  <p>Hi --First Name=there--,</p>
									<p>I noticed you were interested in learning more about growing --Company=your business--. I would like to invite you to our free 30 day business growth course.</p>
                  <p>The course covers all of the basics you'll need to get up and running.  So, what are you waiting for?</p>
                  <a class="blue-btn" href="http://blog.autopilothq.com/lead-nurturing-secrets/"><strong>Register</strong></a>
								</td>
							</tr>
						</table>
						<!-- // END BODY -->
					</td>
			</tr>
			<tr>
				<td align="center" valign="top" id="bodyCellFooter" class="unSubContent">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="templateContainerFooter">
						<tr>
							<td valign="top" width="100%" mc:edit="footer_unsubscribe">
								<h6 style="text-align:center;">COG Inc</h6>
								<h6 style="text-align:center;">589 Howard Street</h6>
								<h6 style="text-align:center;">San Francisco, CA 94105</h6>
								<h6 style="text-align:center;margin-top: 7px;"><a href="--unsubscribe--">unsubscribe</a></h6>
							</td>
						</tr>
					</table>
				</td>
			</tr>

    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="hide" width="600">
  <tr>
    <td height="1" class="hide" style="min-width:600px; font-size:0px;line-height:0px;">
      <img height="1" width="600" src="http://c0185784a2b233b0db9b-d0e5e4adc266f8aacd2ff78abb166d77.r51.cf2.rackcdn.com/blank.jpg" style="min-width: 600px; width: 600px; max-height: 1px; min-height: 1px; text-decoration: none; border: none; -ms-interpolation-mode: bicubic;" />
    </td>
  </tr>
</table>
</body>
</html>
