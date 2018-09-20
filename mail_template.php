<?php

$full_name = "Joe Biden";
$confirm_link = "http://href.ced.com";

$email = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Email Confirmation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
';

$email .= '
<body bgcolor="#FFFFFF" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%!important;" >
  <table border="0" cellpadding="10" cellspacing="0"  width="100%" style="background-color:#FFFFFF;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;border-collapse:collapse!important;" >
    <tr>
      <td style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;" >
        <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;border-collapse:collapse!important;" >
        <tr>
          <td style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;" >
    <![endif]-->

        <table align="center" border="0" cellpadding="0" cellspacing="0" class=
        "content" style="background-color:#FFFFFF;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;border-collapse:collapse!important;width:100%;max-width:600px;" >
          <tr>
            <td id="templateContainerHeader" valign="top" mc:edit="welcomeEdit-01" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;font-size:14px;padding-top:2.429em;padding-bottom:.929em;" >
              <p style="text-align:center;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.5em;font-style:normal;font-weight:400;letter-spacing:normal;" ><img src=
              "http://a-gtm.com/images/logo_nam.png" style="display:inline-block;max-width:100%;border-width:0;line-height:100%;outline-style:none;text-decoration:none;height:auto;min-height:1px;" ></p>
            </td>
          </tr>
';

$email .= '
<tr>
  <td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;" >
    <table border="0" cellpadding="0" cellspacing="0" class=
    "brdBottomPadd-two" id="templateContainer" width="100%" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;border-collapse:collapse!important;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#f0f0f0;border-top-width:1px;border-top-style:solid;border-top-color:#e2e2e2;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;border-radius:4px 4px 0 0;background-clip:padding-box;border-spacing:0;" >
      <tr>
        <td class="bodyContent" valign="top" mc:edit="welcomeEdit-02" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:3.143em;padding-right:3.5em;padding-left:3.5em;text-align:left;padding-bottom:.857em;" >
          <p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.5em;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >
              Hi <strong>
                  ' . $full_name .  '
              </strong>
          </p>

          <h2 style="color:#2e2e2e;display:block;font-family:Helvetica;font-size:22px;line-height:1.455em;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" ><strong>Thanks for signing up with us<br>
              </strong>
          </h2>

          <h3 style="color:#545454;display:block;font-family:Helvetica;font-size:18px;line-height:1.444em;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >
              Please verify your email address by clicking on the button below. Note that this link will
              expire after 24 hours.
          </h3>
        </td>
      </tr>

      <tr style="padding-bottom:20px;" >
          <td style="text-align:center;margin-bottom:20px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;" >
              <a class="blue-btn" href=
                  "' . $confirm_link .  '" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#5098ea;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;display:inline-block;color:#FFFFFF;border-top-width:10px;border-top-style:solid;border-top-color:#5098ea;border-bottom-width:10px;border-bottom-style:solid;border-bottom-color:#5098ea;border-left-width:20px;border-left-style:solid;border-left-color:#5098ea;border-right-width:20px;border-right-style:solid;border-right-color:#5098ea;text-decoration:none;font-size:14px;margin-top:1.0em;border-radius:3px 3px 3px 3px;background-clip:padding-box;" >
                  <strong>
                      Confirm Email
                  </strong>
              </a>
              <br>
          </td>
      </tr>


    </table>
  </td>
</tr>
';


$email .= '
<tr>
  <td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;" >
    <!-- BEGIN BODY // -->

    <table border="0" cellpadding="0" cellspacing="0" id=
    "templateContainerMiddleBtm" width="100%" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;border-collapse:collapse!important;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#e2e2e2;border-radius:0 0 4px 4px;background-clip:padding-box;border-spacing:0;" >
      <tr>
        <td class="bodyContent" valign="top" mc:edit="welcomeEdit-11" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:3.143em;padding-right:3.5em;padding-left:3.5em;text-align:left;padding-bottom:2em;" >
          <h3 style="color:#545454;display:block;font-family:Helvetica;font-size:18px;line-height:1.444em;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >
              <strong>
              </strong>
          </h3>

          <h4 style="color:#545454;display:block;font-family:Helvetica;font-size:14px;line-height:1.571em;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >
              If you did not sign up on our website then please ignore this email.
          </h4>

        </td>
      </tr>
    </table><!-- // END BODY -->
  </td>
</tr>

<tr>
  <td align="center" class="unSubContent" id="bodyCellFooter" valign=
  "top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:39px;padding-bottom:15px;padding-right:0;padding-left:0;width:100%!important;" >
    <table border="0" cellpadding="0" cellspacing="0" id=
    "templateContainerFooter" width="100%" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;border-collapse:collapse!important;" >
      <tr>
        <td valign="top" width="100%" mc:edit="welcomeEdit-11" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0;mso-table-rspace:0;" >
          <p style="text-align:center;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.5em;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;" ><img src=
          "http://c0185784a2b233b0db9b-d0e5e4adc266f8aacd2ff78abb166d77.r51.cf2.rackcdn.com/templates/cog-03.jpg" style="margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;display:inline-block;max-width:100%;border-width:0;line-height:100%;outline-style:none;text-decoration:none;height:auto;min-height:1px;" ></p>

          <h6 style="text-align:center;margin-top:9px;display:block;font-family:Helvetica;font-style:normal;font-weight:400;letter-spacing:normal;margin-right:0;margin-left:0;color:#a1a1a1;font-size:12px;line-height:1.5em;margin-bottom:0;" >AGTM Inc</h6>


          <h6 style="text-align:center;display:block;font-family:Helvetica;font-style:normal;font-weight:400;letter-spacing:normal;margin-top:0;margin-right:0;margin-left:0;color:#a1a1a1;font-size:12px;line-height:1.5em;margin-bottom:0;" >United States</h6>

        </td>
      </tr>
    </table>
  </td>
</tr>
</table><!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
</td>
</tr>
</table>
';

 ?>
