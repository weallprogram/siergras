<?php

class ControllerNewsletterCron extends Controller {

    function printExtender($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
	
	public function index(){
		ini_set("memory_limit", "-1");
        set_time_limit(0);
		
		$this -> load -> model('newsletter/newsletter');
		
		$emailList = $this -> model_newsletter_newsletter -> getEmails(1500);
		
		foreach($emailList as $key => $queueItem){
			$uid = $queueItem['uid'];
			$user_uid = $queueItem['user_uid'];
			$letter_uid	 = $queueItem['newsletter_uid'];
			
			$letterInfo = $this -> model_newsletter_newsletter -> getLetterInfo($letter_uid);
			$userInfo = $this -> model_newsletter_newsletter -> getUserInfo($user_uid);
			
			if(!isset($userInfo['email'])){
				$this -> model_newsletter_newsletter -> unsubscribe($user_uid);
				continue;
			}
			$userEmail = $userInfo['email'];
			
			$letterInfo['subject'] = html_entity_decode($letterInfo['subject']);
            $letterInfo['subject'] = html_entity_decode($letterInfo['subject'], ENT_QUOTES, 'UTF-8');
			
			$letterInfo['content'] = html_entity_decode(html_entity_decode($letterInfo['content']));
			$letterInfo['content'] = str_replace("newsletter/unsubscribe", "newsletter/unsubscribe&id=" . $user_uid, $letterInfo['content']);
			
			$message = '<html dir="ltr" lang="en">' . PHP_EOL;
            $message .= '<head>' . PHP_EOL;
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . PHP_EOL;
            $message .= '<title>' . $letterInfo['subject'] . '</title>' . PHP_EOL;
            $message .= '</head>' . PHP_EOL;
            $message .= '<body style="padding:0;margin:0;">' . $letterInfo['content'] . '</body>' . PHP_EOL;
            $message .= '</html>' . PHP_EOL;
			
			if ($this -> model_newsletter_newsletter -> sendHTMLemail($message, $letterInfo['from'], $userEmail, $letterInfo['subject'], $letter_uid, $uid, $user_uid)) {
                $this -> model_newsletter_newsletter -> letterDone($uid,$letter_uid);
            }
		}
		$this -> response -> setOutput(date('Y-m-d H:i:s') . ' - ok');
	}

    public function index_old() {
        ini_set("memory_limit", "-1");
        set_time_limit(0);

		// if(date("Hi") < 2200 && date("Hi") > 700)
		// {
		//   $this -> response -> setOutput(date('Y-m-d H:i:s') . ' - Het is overdag, en om de load op de server te verminderen wordt er nu niks uitgevoerd.');
		//   return;
		// }
		
        $this -> load -> model('newsletter/newsletter');

        $emailList = $this -> model_newsletter_newsletter -> getEmails(1500);
        foreach ($emailList as $key => $value) {
            $to = $value['to'];
            $from = $value['from'];
            $subject = html_entity_decode($value['subject']);
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $message = $this -> model_newsletter_newsletter -> getEmailContent($value['uid']);
            $msg = $message['content'];
            $msg = html_entity_decode(html_entity_decode($msg));
            // $msg = str_replace(chr(128), "&euro;", $msg);

            $msg = str_replace("newsletter/unsubscribe", "newsletter/unsubscribe&id=" . $value['user_uid'], $msg);

            $message = '<html dir="ltr" lang="en">' . PHP_EOL;
            $message .= '<head>' . PHP_EOL;
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . PHP_EOL;
            $message .= '<title>' . $subject . '</title>' . PHP_EOL;
            $message .= '</head>' . PHP_EOL;
            $message .= '<body style="padding:0;margin:0;">' . html_entity_decode($msg, ENT_QUOTES, 'UTF-8') . '</body>' . PHP_EOL;
            $message .= '</html>' . PHP_EOL;

            if ($this -> model_newsletter_newsletter -> sendHTMLemail($message, $from, $to, $subject, $value['uid'])) {
                $this -> model_newsletter_newsletter -> insertEmailsDone($value['uid']);
                $this -> model_newsletter_newsletter -> done($value['uid']);
            }
        }

        $this -> response -> setOutput(date('Y-m-d H:i:s') . ' - ok');
    }

}
