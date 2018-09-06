<?php
namespace Grav\Plugin;

use Grav\Common\Data\Blueprints;
use Grav\Common\Plugin;
use Grav\Common\Uri;
use RocketTheme\Toolbox\Event\Event;

class WebPushPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
        ];
    }
    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        // Set default events
        $events = [
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
        ];
        // Set admin specific events
        if ($this->isAdmin()) {
            $this->active = false;
            $events = [
                'onBlueprintCreated' => ['onBlueprintCreated', 0],
                'onAdminSave' => ['onAdminSave', 0],
            ];
        }
        // Register events

        $this->enable($events);
    }

    public function onAdminSave(Event $event)
    {
        global $page;
        if (isset($_POST['data']['header']['webpushbutton'])) {
            $notification_check = $_POST['data']['header']['webpushbutton']['send'];

            global $app_id, $rest_id;
            $app_id = $this->config->get('plugins.webpush.app_id');
            $rest_id = $this->config->get('plugins.webpush.rest_id');

            if ($notification_check == 1) {
                function sendMessage($title, $message, $file, $url)
                {
                    global $page, $app_id, $rest_id;
                    $content = array(
                        "en" => $message,
                    );
                    $headings = array(
                        "en" => $title,
                    );
                    $fields = array(
                        'app_id' => $app_id,
                        'included_segments' => array(
                            'All',
                        ),
                        'chrome_web_icon' => $page->url(true) . $file,
                        'contents' => $content,
                        'headings' => $headings,
                        'url' => $url,
                    );

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic '. $rest_id .'',
                    ));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);
                    curl_close($ch);
                    return $response;
                }

                $title = $_POST['data']['header']['webpushtitle'];
                $message = $_POST['data']['header']['webpushmessage'];
                $file = $_POST['data']['header']['webpushimage'];
                $url = $_POST['data']['header']['webpushurl'];
                sendMessage($title, $message, $file, $url);
            }
        }
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
        $this->grav['assets']
            ->addJs('plugin://webpush/assets/helper.js');
    }
    /**
     * Extend page blueprints with WebPush configuration options.
     *
     * @param Event $event
     */
    public function onBlueprintCreated(Event $event)
    {
        global $page;
        $page = $this->grav['page'];
        $newtype = $event['type'];
        if (0 === strpos($newtype, 'modular/')) {
        } else {
            $blueprint = $event['blueprint'];
            if ($blueprint->get('form/fields/tabs', null, '/')) {
                $blueprints = new Blueprints(__DIR__ . '/blueprints/');
                $extends = $blueprints->get($this->name);
                $blueprint->extend($extends, true);
            }
        }
    }
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }
}
