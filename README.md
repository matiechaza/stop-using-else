# Why should you stop using "else"?

With examples in PHP, I will comment why it is important to avoid the nesting of IF statements and the large amount of ELSE.

## Nested IF statements

Sometimes, we find that our code contains many IF statements within itself, which makes us suspect if something is wrong with this or not. For example:

```php
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
```

The previous code itself is not wrong. But, if we look more closely, we will realize that we have three nested IFs with three ELSEs that contain different ways of dealing with errors.

In addition, we force our code to have three levels of indentation making a code not clean.

And the last problem that we can detect is that, if we have a large amount of code in the deepest levels (or not) of the IF, we must scroll until the end of the method to know what the ELSEs do.

So, let's see how to refactor the code.

## Refactoring the code

```php
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
```

As we can see, what we are doing is denying the condition of each IF and, if the denial is met, we make the refund or throw the exception. This is called Guard Clauses.

## Benefits

* Clean code.
* Code flow easier to follow.
* Reduction of indentation levels.
* Your colleagues will thank you.

That was all. I hope this example has helped you 😀.
