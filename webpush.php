<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class WebPushPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        ];
    }

    public function onTwigSiteVariables()
    {
        $this->grav['assets']
            ->addJs('https://cdn.onesignal.com/sdks/OneSignalSDK.js', ['loading' => 'async']);
        $this->grav['assets']
            ->addInlineJs('
            var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
              appId: "' . $this->config->get('plugins.webpush.app_id') . '",
              safari_web_id: "' . $this->config->get('plugins.webpush.safari_id') . '",
              autoRegister: ' . (($this->config->get('plugins.webpush.auto_prompt') == 1) ? 'true' : 'false') . ',
              allowLocalhostAsSecureOrigin: true,
              notifyButton: {
                enable: ' . (($this->config->get('plugins.webpush.bell') == 1) ? 'true' : 'false') . ',
                size: "' . $this->config->get('plugins.webpush.bell_size') . '",
                theme: "' . $this->config->get('plugins.webpush.bell_theme') . '",
                position: "' . $this->config->get('plugins.webpush.bell_position') . '",
                offset: {
                    bottom: "' . $this->config->get('plugins.webpush.bottom_offset') . '",
                    left: "' . $this->config->get('plugins.webpush.left_offset') . '",
                    right: "' . $this->config->get('plugins.webpush.right_offset') . '",
                },
                prenotify: ' . (($this->config->get('plugins.webpush.bell_unread') == 1) ? 'true' : 'false') . ',
                showCredit: false,
                text: {
                    "tip.state.unsubscribed": "' . $this->config->get('plugins.webpush.unsubscribed') . '",
                    "tip.state.subscribed": "' . $this->config->get('plugins.webpush.subscribed') . '",
                    "tip.state.blocked": "' . $this->config->get('plugins.webpush.blocked') . '",
                    "message.prenotify": "' . $this->config->get('plugins.webpush.firsttime') . '",
                    "message.action.subscribed": "' . $this->config->get('plugins.webpush.message_subscribed') . '",
                    "message.action.resubscribed": "' . $this->config->get('plugins.webpush.message_resubscribed') . '",
                    "message.action.unsubscribed": "' . $this->config->get('plugins.webpush.message_unsubscribed') . '",
                    "dialog.main.title": "' . $this->config->get('plugins.webpush.main_dialog') . '",
                    "dialog.main.button.subscribe": "' . $this->config->get('plugins.webpush.main_dialog_subscribe') . '",
                    "dialog.main.button.unsubscribe":  "' . $this->config->get('plugins.webpush.main_dialog_unsubscribe') . '",
                    "dialog.blocked.title":  "' . $this->config->get('plugins.webpush.blocked_dialog_title') . '",
                    "dialog.blocked.message": "' . $this->config->get('plugins.webpush.blocked_dialog_message') . '",
                },
                displayPredicate: function() {
                    return OneSignal.isPushNotificationsEnabled()
                        .then(function(isPushEnabled) {
                            return !isPushEnabled;
                        });
                }
              },
              welcomeNotification: {
                "title": "' . $this->config->get('plugins.webpush.welcome_title') . '",
                "message": "' . $this->config->get('plugins.webpush.welcome_message') . '",
                "url": "' . $this->config->get('plugins.webpush.welcome_url') . '",
              },
              promptOptions: {
                siteName: "' . $this->config->get('plugins.webpush.sitename') . '",
                actionMessage:  "' . $this->config->get('plugins.webpush.action_message') . '",
                exampleNotificationTitle: "' . $this->config->get('plugins.webpush.example_title') . '",
                exampleNotificationMessage: "' . $this->config->get('plugins.webpush.example_message') . '",
                exampleNotificationCaption: "' . $this->config->get('plugins.webpush.example_caption') . '",
                acceptButtonText: "' . $this->config->get('plugins.webpush.accept') . '",
                cancelButtonText: "' . $this->config->get('plugins.webpush.cancel') . '",
              }
            }]);
            OneSignal.push(function() {
              OneSignal.showHttpPrompt();
            });');
    }
}
