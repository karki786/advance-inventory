<?php


namespace CodedCell\Repository\Message;


interface MessageInterface
{

    /**
     * Saves email/notification in database
     * @param $message
     * @param $userRole
     * @return mixed
     */
    public function createMessage($message, $userRole);

    /**
     * Sends message through email, If message was sent within
     * the specified period it is not sent.
     * @param array $message
     * @param $period
     * @return mixed
     */
    public function sendMessage(array $message, $period);

    /**
     * Set Specified Message as read
     * @param $id
     * @return mixed
     */
    public function setMessageAsRead($id);

    /**
     * Set Specified Message as sent
     * @param $id
     * @return mixed
     */
    public function setMessageAsSent($id);

    /**
     * Used to get unread Messages
     * @return mixed
     */
    public function getUnreadNotifications();

    /**
     * Gets Read Messages
     * @return mixed
     */
    public function getReadNotifications();

    /**
     * Gets all sent emails
     * @return mixed
     */
    public function getSentEmails();

    /**
     * Get All Emails
     * @return mixed
     */
    public function getAllEmails();

    /**
     * Used to send emails
     * @param array $message
     * @param $email
     * @return mixed
     */
    public function sendEmails($message);

    /**
     * Deletes Message based on item Id.
     * @param $itemId
     * @return mixed
     */
    public function deletePrinterMessage($itemId);

}