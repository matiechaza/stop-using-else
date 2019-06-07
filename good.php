class ServiceUser
{
    const NOTIFICATION_NOT_SENT = 0;
    const NOTIFICATION_SUCCESSFULLY_SENT = 1;

    public function __invoke($user_id)
    {
        // Guardian clauses
        if (!$this->isVerified($user_id)) {
            throw new UserIsNotVerified;
        }
        
        // Guardian clauses
        if (!$this->hasNotificationsEnabled($user_id)) {
            throw new NotificationIsNotEnabled;
        }
        
        // Guardian clauses
        if (!$this->shouldUserBeNotified($user_id)) {
            return self::NOTIFICATION_NOT_SENT;
        }
        
        $this->sendNotification();
        return self::NOTIFICATION_SUCCESSFULLY_SENT;
    }
    
    private function isVerified($user_id) {}
    private function hasNotificationsEnabled($user_id) {}
    private function shouldUserBeNotified($user_id) {}
    private function sendNotification($user_id) {}
}