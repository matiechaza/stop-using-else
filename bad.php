class ServiceUser
{
    const NOTIFICATION_NOT_SENT = 0;
    const NOTIFICATION_SUCCESSFULLY_SENT = 1;

    public function __invoke($user_id)
    {
        if ($this->isVerified($user_id)) {
            if ($this->hasNotificationsEnabled($user_id)) {
                if ($this->shouldUserBeNotified($user_id)) {
                    $this->sendNotification();
                    
                    return self::NOTIFICATION_SUCCESSFULLY_SENT;
                } else {
                    return self::NOTIFICATION_NOT_SENT;
                }
            } else {
                throw new NotificationIsNotEnabled;
            }
        } else {
            throw new UserIsNotVerified;
        }
    }
    
    private function isVerified($user_id) {}
    private function hasNotificationsEnabled($user_id) {}
    private function shouldUserBeNotified($user_id) {}
    private function sendNotification($user_id) {}
}