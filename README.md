# mastodon-welcome-bot

## Getting Started

This bot sends private messages to the latest follower of your welcome bot.

## Prerequisites

- A php5.6+ environment to run your bot
- Crontab to run this script at a certain frequency
- User ID (an integer) of your welcome bot account
- Users must automatically follow this account when they sign up (configure in your Mastodon instance's admin panel)

## Configuration

Follow these steps:

1. Put `bot.php` in a php environment such as a website hosting server.
2. Edit the configuration area in `bot.php` with the token of your Mastodon bot account, URL of your instance, your welcome messgaes, etc.
3. Create an empty file named `newest_user_id.txt` in the same directory.
4. Set the permission of `newest_user_id.txt` file to be writable.
5. Test running `bot.php` to see if it works.
6. Create a crontab to frequently run `bot.php`, for example, every 1 minute.

## Author

- Author's Website: https://yanziyao.cn
- Author's Mastodon: https://o3o.ca/@salt

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.