# coral-mattermost
A script to help [Coral](https://coralproject.net/) send messages to a Mattermost instance via the Slack integration.

Natively, Coral's dashboard let you setup a webhook to any existing Slack instance. This can be useful, for instance, to have all reported messages posted to a dedicated channel for the moderating team to review them. But it only work for Slack. This tool let you use Mattermost for this purpose.

## Coral and Mattermost 

![Mattermost](https://about.mattermost.com/wp-content/uploads/2017/08/Mattermost-Logo-Blue.svg =250x)

Mattermost is an open source Slack self hosted alternative :

> All team communication in one place, searchable and accessible anywhere. Mattermost is an open source, private cloud, Slack-alternative from https://mattermost.com. It's written in Golang and React and runs as a single Linux binary with MySQL or PostgreSQL. 

<img src="https://cdn.vox-cdn.com/thumbor/104MCEWzKTgejtBSadMsOq1ZSnE=/0x0:1013x389/1200x0/filters:focal(0x0:1013x389):no_upscale()/cdn.vox-cdn.com/uploads/chorus_asset/file/19184651/Logo_horizontal_color__1_.png" alt="Coral by Vox media" style="zoom: 50%;" />

Here is a little description of what Coral is about : 

> Online comments are broken. Our open-source commenting platform, Coral, rethinks how moderation, comment display, and conversation function, creating the opportunity for safer, smarter discussions around your work. Read more about Coral [here](https://coralproject.net/talk).

## Getting Started

This script is build as a proxy between Coral's Slack integration and your Mattermost instance. It will receive all queries send from Coral, parse the content - encoded in [Slack Markdown](https://www.markdownguide.org/tools/slack/) - to standard markdown. It will then trigger a Mattermost webhook to post the content in the dedicated channel.

### Prerequisites

What you need before starting : 

- A working [Mattermost Instance](https://docs.mattermost.com/guides/administrator.html#installing-mattermost) 
- A working Coral instance
- A public web server running at least PHP 5



### Installing

First, you need to create a webhook in your Mattermost instance: 

1. Click on the burger button placed in the sidebar, just at the right of your name.

2. Click on "Integrations" and then on "incoming webhooks"

3.  Click on the "Add incoming webhook" button at the top of the page.

4. Type in a title (ie: "Coral integration") and a description ("Incoming webhook from coral-mattermost")

5. Select the channel where the message will be posted - it should already exist - and check the "lock channel" box so that the webhook will only be able to send messages in this channel. It feels safer - to me at least - to set the webhook this way, so it can't be used to hack into your Mattermost instance. You don't need to set a username and a profile picture.

6. Click update, and then copy the webhook url, who should look like this : 

   ```url
   https://[mattermost url]/hooks/[key]
   ```

   

You then need to clone `coral-mattermost`'s repo to your web server and set it up.

Let's assume you have a public webserver whose url is `https://mywebserver.cool`

Go to your webroot and type in

```shell
git clone https://github.com/gfra54/coral-mattermost.git
```

Then, you need to rename the `config.ini.sample` file to `config.ini` and edit it to fit your needs:

````
[Mattermost]
; the custom webhook url you defined in Mattermost
webhook = "https://[mattermost url]/hooks/[key]"

; The username displayed for each message poster via the webhook
username = "Coral"

; the avatar displayed for each message posted via the webhook 
avatar = "https://avatars1.githubusercontent.com/u/9255912?s=200&v=4"

[Behaviour]
; put one or more mattermost usernames prefixed 
; with @ to send notifications ot each of them
; when the webhook is triggered.
mention = "@all"
````

You need to put every value between quotes for the config file to work.

Now, your `coral-mattermost` instance is available at https://mywebserver.cool/coral-mattermost. This will be your "custom webhook".

You now need to declare this url in Coral's dashboard.

1. Go to your dashboard, then click on the "Configure" menu at the top.
2. Click on "Slack" in the side menu, then click "Add a channel"
3. Set a name (ie: "Mattermost") and paste the custom webhook url in the "Webhook URL" field.
4. Select what you want to be sent to the webhook : Reported comments, pending comments or featured comments.
5. Click "Save". That's it. When a comment will be reported, a message will be sent 

If you want to send each type of comments to 3 differents channels, it is possible, but for now the only solution is to clone `coral-mattermost` 3 times and to set 3 different webhooks. A future version of `coral-mattermost` will include the possibility to set the channel via the webhook url. 

## Author

* **Gilles FRANCOIS** - *Initial work* - [gfra54](https://github.com/gfra54)

## License

This project is licensed under the GNU GENERAL PUBLIC LICENSE - see the [LICENSE](LICENSE) file for details

## Acknowledgments

* This code is pretty basic and may need to be improved. All pull requests are welcome
* Coral is a great community tool, you should try it
* Mattermost is a great productivity tool, you sould try it too !

