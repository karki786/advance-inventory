<?php namespace CodedCell\Repository\Message;

use App\Message;
use App\User;
use Auth;
use Carbon\Carbon;
use Mail;

class MessageEntity implements MessageInterface
{

    /**
     * Saves email/notification in database
     * @param $message
     * @param $userRole
     * @return mixed
     */
    public function createMessage($message, $userRole)
    {
        $emailMessages = array();
        $users = User::with('setting')->whereRoleId($userRole)->get();
        foreach ($users as $user) {
            $emailMessage = array(
                'name' => $user->name,
                'emailTo' => $user->email,
                'itemId' => $message['itemId'],
                'userId' => $user->id
            );
            if ($user->setting) {
                $response = $this->sendMessage($emailMessage, $user->setting->printersDowntime);
                if ($response == true) {
                    $message['sent'] = 1;
                    $message['userId'] = $user->id;
                    $Tomessage = Message::create($message);
                    array_push($emailMessages, $Tomessage->toArray());
                }
            }
        }

        return $emailMessages;
    }

    /**
     * Used to send emails
     * @param array $message
     * @return mixed
     */
    public function sendEmails($message)
    {
        $superUsers = User::whereRoleId(1)->get();
        $x = array();
        foreach ($message as $single) {
            foreach ($single as $s) {
                array_push($x, $s);
            }
        }
        $message = $x;

        foreach ($superUsers as $user) {
            $id = $user->id;
            $email = $user->email;

            $superUserNotifications = array_where($message, function ($key, $value) use ($id) {
                if ($value['userId'] == $id) {
                    return $value;
                }
            });

            if (count($superUserNotifications) > 0) {
                Mail::send('emails.printers', array('messages' => $superUserNotifications),
                    function ($message) use ($email) {
                        $message->to($email)->subject('Hi I could not get the status for the following printers');
                    });
            }
        }


    }

    /**
     * Sends message through email, If message was sent within
     * the specified period it is not sent.
     * @param array $message
     * @param $period
     * @return mixed
     */
    public function sendMessage(array $message, $period)
    {

        $count = Message::where(
            'created_at',
            '>',
            Carbon::now()->subHours($period)
        )
            ->whereItemidAndUserid($message['itemId'], $message['userId'])->count();
        if ($count == 0) {
            Message::whereItemidAndUserid($message['itemId'], $message['userId'])->delete();
            return true;
        }
        return false;
    }

    /**
     * Set Specified Message as read
     * @param $id
     * @return mixed
     */
    public function setMessageAsRead($id)
    {
        return Message::whereId($id)->update(array('isRead' => 1));
    }

    /**
     * Used to get unread Messages
     * @return mixed
     */
    public function getUnreadNotifications()
    {
        return Message::whereIsreadAndUserid(0, Auth::user()->id)->get();
    }

    /**
     * Gets Read Messages
     * @return mixed
     */
    public function getReadNotifications()
    {
        return Message::whereIsreadAndUserid(1, Auth::user()->id)->get();
    }

    /**
     * Gets all sent emails
     * @return mixed
     */
    public function getSentEmails()
    {
        if (Auth::user()) {
            return Message::whereSentAndMessagetypeAndUserid(1, 1, Auth::user()->id)->get();

        } 
    }

    /**
     * Set Specified Message as sent
     * @param $id
     * @return mixed
     */
    public function setMessageAsSent($id)
    {
        return Message::whereId($id)->update(array('sent' => 1));
    }

    /**
     * Get All Emails
     * @return mixed
     */
    public function getAllEmails()
    {
        return Message::paginate(env('RECORDS_VIEW'))->setPath('');
    }


    /**
     * Deletes Message based on item Id.
     * @param $itemId
     * @return mixed
     */
    public function deletePrinterMessage($itemId)
    {
        return Message::whereItemid($itemId)->delete();
    }
}