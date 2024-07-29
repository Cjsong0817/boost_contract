<?php
namespace App\Helper;

class SendCloud
{
    private $url;
    private $API_USER;
    private $appId;
    private $appSecret;
    private $Sender;

    public function __construct()
    {
        $this->url = 'http://api.sendcloud.net/apiv2/mail/send';
        $this->API_USER = 'winato';
        $this->API_KEY = '44118cfec403a5198e71ce318014e696';
        $this->Sender = 'support@winato.com';
    }
    public function publicOtp($email, $amount = 0, $template = 'public_otp')
    {
        $to = $email;
        $username = $email;
        $lang = 'en';

        $subject = 'ETFinance Registration Verification Code';
        $content = '<p><span style="font-size:11pt;">Dear ' . $username . ',</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Thank you for choosing ETFinance. To ensure the security of your account, we are sending you this email to provide your registration verification code.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Verification Code: ' . $amount . '</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Please enter the above code during the registration process to complete your registration. This code will be valid for 10 minutes from the time this email is received. If it expires, please request a new verification code.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">If you have any questions or need further assistance, please do not hesitate to contact our customer support team at support@etfinance.io.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Thank you for your trust and support in ETFinance.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Sincerely,</span></p>
<p><br></p>
<p><span style="font-size:11pt;">ETFinance Customer Support Team</span></p>';

        $this->sendMail($to, $subject, $content);
    }
    public function mailTemplate($user, $amount = 0, $template = 'welcome')
    {
        $to = $user->email;
        $username = $user->username;
        $lang = $user->bio;
        if ($template == 'welcome') {
            if ($lang == 'cn') {
                $subject = '欢迎加入ETFinance - 您的账户已注册成功';
                $content = '<p>尊敬的用户，</p>
<p><br></p>
<p>恭喜您成功注册 ETFinance 账户！您现在可以访问我们的平台并开始管理您的投资。为确保您的账户安全，请记得定期更新密码。</p>
<p><br></p>
<p>如果您有任何疑问或需要进一步帮助，请随时通过 <a data-fr-linked="true" href="mailto:support@etfinance.io">support@etfinance.io</a> 联系我们的客户支持团队。</p>
<p><br></p>
<p>感谢您对 ETFinance 的信任和支持。</p>
<p><br></p>
<p>诚挚的，</p>
<p><br></p>
<p>ETFinance 客户支持团队</p>';
            } else {
                $subject = 'Welcome to ETFinance - Your Account is Successfully Registered!';
                $content = '<p><span style="font-size:11pt;">Dear ' . $username . ',</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Congratulations on successfully registering your ETFinance account! You can now access our platform and start managing your investments. To ensure the security of your account, please remember to update your password regularly.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">If you have any questions or need further assistance, please do not hesitate to contact our customer support team at support@etfinance.io.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Thank you for your trust and support in ETFinance.</span></p>
<p><br></p>
<p><span style="font-size:11pt;">Sincerely,</span></p>
<p><br></p>
<p><span style="font-size:11pt;">ETFinance Customer Support Team</span></p>';
            }
        } elseif ($template == 'kyc_approve') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 身份认证已通过';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>欢迎来到BtcIno系统。在此通知您，您的账户现已激活，您可以通过登录 <a href='" . url('') . "'>[此处]</a> 选择所需的交易工具并立即开始交易。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>请点击  <a href='" . url('') . "'>[此处]</a>登录您的帐户，如果您有任何疑问，请随时与我们联系 <a href='" . url('') . "'>[此处]</a>。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>BtcIno团队希望您享受我们提供的服务并与我们共同体验。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>BtcIno团队</p>
                <p>
                  <span style='font-size:15px;line-height:107%;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</span>
                </p>";
            } else {
                $subject = 'BtcIno KYC approved';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Welcome to BtcIno System. We would like to inform you that your account is now active and you can begin trading immediately by logging in <a href='" . url('') . "'>[here]</a> and selecting your desired trading instruments. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Please click  <a href='" . url('') . "'>Here</a> to login to your account and do feel free to contact us <span style=color:#4472C4;><a href='" . url('') . "'>[here]</a>&nbsp;</span>if you do have any queries. &nbsp; </p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>On behalf of the BtcIno Team, we hope that you enjoy your journey with us. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team BtcIno</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>
                <em>This is an automatically generated message. Please do not reply.&nbsp;</em>
                </p>";
            }
        } elseif ($template == 'kyc_rejected') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 身份认证审核失败';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>我们想通知您，您的 KYC 提交已被拒绝。</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这可能是由以下几项原因导致；</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 身份证件已过期。</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 提交的文件已被我们的运营商标记为伪造。</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 在系统中输入的数据与上传的文件不匹配。</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 上传的文件不清晰可见、部分覆盖或模糊。</p>

              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>BtcIno团队</p>";
            } else {
                $subject = 'BtcIno KYC rejected';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We would like to inform you that your KYC submission was rejected.</p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>This may due to the following reasons;</p>
              <ul style='list-style-type: undefined;margin-left:0in;'>
                <li>
                  <span style='color:black;'>Identity document has expired.</span>
                </li>
                <li>
                  <span style='color:black;'>The submitted document has been flagged as falsified by our operator.</span>
                </li>
                <li>
                  <span style='color:black;'>Data entered in the system does not match uploaded documents.</span>
                </li>
                <li>
                  <span style='color:black;'>Uploaded documents are not clearly visible, partially covered or blurred. &nbsp; &nbsp;</span>
                </li>
              </ul>

              </p>
              <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team BtcIno            </p> ";
            }
        } elseif ($template == 'withdraw_pending') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 提现处理中';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>我们已收到您从您的交易账户中提取  " . $amount . "USDT 金额的请求</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>在此通知您，您的交易正在处理中。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>如果您没有操作此交易，请立即更改您的密码并在&ldquo;这里&rdquo;联系我们。我们的客服人员会在最短的时间内为您服务。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>BtcIno团队</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</p>";
            } else {
                $subject = 'BtcIno Withdraw is pending';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We have received your withdrawal request for the amount of " . $amount . "USDT from your trading account</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We are pleased to inform you that your transaction is being processed.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>If you did not authenticate this transaction, please immediately change your password and contact us &ldquo;<a href='" . url('') . "'>[here]</a>&rdquo;. Our customer service officers will attend to you in the shortest time possible. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team BtcIno &nbsp;</p>
                <p>
                  <span style='font-size:15px;line-height:107%;font-family:Calibri,sans-serif;'>This is an automatically generated message. Please do not reply.&nbsp; <br>&nbsp; </span>
                </p>";
            }
        } elseif ($template == 'withdraw_approved') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 提现完成';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>您提现 " . $amount . " USDT 已处理完毕。请登录以查看您的余额。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>如果您没有操作此交易，请立即更改您的密码并在&ldquo;这里&rdquo;联系我们。我们的客服人员会在最短的时间内为您服务。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>BtcIno团队</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</p>";
            } else {
                $subject = 'BtcIno Withdraw is approved';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Your withdrawal of " . $amount . " USDT have been processed. Please log in to check your balances. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>If you did not authenticate this transaction, please immediately change your password and contact us &ldquo;<a href='" . url('') . "'>[here]</a>&rdquo;. Our customer service officers will attend to you in the shortest time possible. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team BtcIno &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>This is an automatically generated message. Please do not reply.&nbsp;</p>";
            }
        } elseif ($template == 'withdraw_rejected') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 提现失败';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>亲爱的" . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>您从交易账户中提取 " . $amount . " 的请求已被拒绝。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>请<a href='" . url('') . "'>[此处]</a>联系我们以获取进一步说明。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>BtcIno团队</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</p>";
            } else {
                $subject = 'BtcIno Withdraw is rejected';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Your withdrawal request of " . $amount . " from your trading account has been rejected.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Please contact us <a href='" . url('') . "'>[here]</a> for further clarifications.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team BtcIno &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>This is an automatically generated message. Please do not reply.&nbsp;</p>";
            }
        } elseif ($template == 'forget_password') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 验证码';
                $content = "<p>敬爱的" . $username . "</p>
                <p>我们已接收您的更换密码请求。如果您没提出此次请求，请忽略这封电邮。</p>
                <p>
                  <br>
                </p>
                <p>您的验证码是" . $amount . ".&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>BtcIno团队</p>
                <p>这是一条自动生成的消息。请勿回复</p>";
            } else {
                $subject = 'BtcIno Verification code';
                $content = "<p>Dear " . $username . ",&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>There was a request to change your password! If you did not make this request then please ignore this email.&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>Your verification code is " . $amount . ".&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>BtcIno Support Team&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>This is an automatically generated message. Please do not reply.</p>";
            }
        } elseif ($template == 'forget_password_success') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 验证码';
                $content = "<p>敬爱的" . $username . "</p>
              <p>您的密码已成功更改。如果您没提出此次请求，请忽略这封电邮。</p>
              <p>
                <br>
              </p>
              <p>
                <br>
              </p>
              <p>BtcIno团队</p>
              <p>这是一条自动生成的消息。请勿回复</p>";
            } else {
                $subject = 'BtcIno Verification code';
                $content = "<p>Dear " . $username . ",&nbsp;</p>
              <p>
                <br>
              </p>
              <p>Your password has been successfully reset. If you did not make this request then please ignore this email.&nbsp;</p>
              <p>
                <br>
              </p>
              <p>
                <br>
              </p>
              <p>BtcIno Support Team&nbsp;</p>
              <p>
                <br>
              </p>
              <p>This is an automatically generated message. Please do not reply.</p>";
            }
        } elseif ($template == 'package_subscription') {
            if ($lang == 'cn') {
                $subject = 'BtcIno 验证码';
                $content = "<p>敬爱的" . $username . "</p>
            <p>您所选服务计划已成功激活。如果您没提出此次请求，请忽略这封电邮。</p>
            <p>
              <br>
            </p>
            <p>
              <br>
            </p>
            <p>BtcIno团队</p>
            <p>这是一条自动生成的消息。请勿回复</p>";
            } else {
                $subject = 'BtcIno Verification code';
                $content = "<p>Dear " . $username . ",&nbsp;</p>
            <p>
              <br>
            </p>
            <p>The service plan has been successfully subscribed. If you did not make this request then please ignore this email.&nbsp;</p>
            <p>
              <br>
            </p>
            <p>
              <br>
            </p>
            <p>BtcIno Support Team&nbsp;</p>
            <p>
              <br>
            </p>
            <p>This is an automatically generated message. Please do not reply.</p>";
            }
        } elseif ($template == 'public_otp') {
            if ($lang != 'cn') {
                $subject = 'BtcIno Verification code';
                $content = "<p>Dear " . $username . ",&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>Your verification code is as follows. To ensure your account security, this verification code is valid within 30 minutes, please reacquire after timeout.</p>
                <p>
                  <br>
                </p>
                <p>Your verification code is " . $amount . ".&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>BtcIno Support Team&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>This is an automatically generated message. Please do not reply.</p>";
            } else {
                $subject = 'BtcIno Verification code';
                $content = "<p>Dear " . $username . "</p>
                <p>Your verification code is as follows. To ensure your account security, this verification code is valid within 30 minutes, please reacquire after timeout.</p>
                <p>
                  <br>
                </p>
                <p>Your verification code is " . $amount . ".&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>BtcIno Support Team&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>This is an automatically generated message. Please do not reply.</p>";

            }
        }

        $this->sendMail($to, $subject, $content);
    }
    public function sendMail($to, $subject, $content)
    {
        $body_content = "<!doctype html>
<html>
<head>
<title></title>
<style type='text/css'>
body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
img { -ms-interpolation-mode: bicubic; }

img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
table { border-collapse: collapse !important; }
body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

@media screen and (max-width: 600px) {
  .img-max {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
  }

  .max-width {
    max-width: 100% !important;
  }

  .mobile-wrapper {
    width: 85% !important;
    max-width: 85% !important;
  }

  .mobile-padding {
    padding-left: 5% !important;
    padding-right: 5% !important;
  }
}
div[style*='margin: 16px 0;'] { margin: 0 !important; }
.im{
    color:black!important;
}
</style>
</head>
<body style='margin: 0 !important; padding: 0; !important background-color: #ffffff;' bgcolor='#ffffff'>

<div style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>

</div>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tr>
        <td align='center' valign='top' width='100%' background='bg.jpg' bgcolor='#f6f6f6' style='background: #f6f6f6 url(bg.jpg); background-size: cover; padding: 35px 15px 0 15px;' class='mobile-padding'>
            <!--[if (gte mso 9)|(IE)]>
            <table align='center' border='0' cellspacing='0' cellpadding='0' width='600'>
            <tr>
            <td align='center' valign='top' width='600'>
            <![endif]-->
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                <tr>
                    <!--td align='center' valign='top' style='padding: 0 0 50px 0;'>

                    </td-->
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
            <img src='" . url('') . "/images/logo.png' border='0' style='display: block;height:100px;'>
            <br><br>
        </td>
    </tr>
    <tr>
        <td align='center' height='100%' valign='top' width='100%' bgcolor='#f6f6f6' style='padding: 0 15px 50px 15px;' class='mobile-padding'>
            <!--[if (gte mso 9)|(IE)]>
            <table align='center' border='0' cellspacing='0' cellpadding='0' width='600'>
            <tr>
            <td align='center' valign='top' width='800'>
            <![endif]-->
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 0 0 25px 0; font-family: Open Sans, Helvetica, Arial, sans-serif;'>
                        <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                            <tr>
                                <td align='center' bgcolor='#ffffff' style='border-radius: 0 0 3px 3px; padding: 25px;'>
                                    <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                        <tr>
                                            <td align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif;'>

                                                <p style='margin-top:0in;text-align: left;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;color: black!important;'>
                                                    $content
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
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
    <tr>
        <td align='center' height='100%' valign='top' width='100%' bgcolor='#f6f6f6' style='padding: 0 15px 40px 15px;'>
            <!--[if (gte mso 9)|(IE)]>
            <table align='center' border='0' cellspacing='0' cellpadding='0' width='600'>
            <tr>
            <td align='center' valign='top' width='600'>
            <![endif]-->
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>

                <p>&copy;BtcIno</p>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>
</body>
</html>
"; //邮件内容

        $details = [
            'title' => $subject,
            'body' => $body_content,
        ];
        $r = \Mail::to($to)->send(new \App\Mail\Send_Mail($details));

        return response()->json([
            'data' => $r,
            'status' => true,
        ]);
    }
}
