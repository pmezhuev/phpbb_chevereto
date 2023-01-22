# Chevereto API and PUP for phpBB 3.2/3.3

## Requirements
* phpBB 3.2+
* PHP 5.4+
* curl

## Install
1. [Download latest release](https://github.com/LordBeaver/phpbb_chevereto/releases).
2. Unzip to the `ext` directory of your phpBB board.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Chevereto API` under the `Disabled Extensions` list and click its `Enable` link.
5. Navigate in the ACP to `Extensions -> Chevereto API -> Settings`.

## Upgrade
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Chevereto API`.
3. Delete the `chevereto` folder from `ext/lordbeaver`.
4. Go to [Install](#install).

## Uninstall
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Chevereto API`.
3. To permanently uninstall, click `Delete Data`, then delete the `chevereto` folder from `ext/lordbeaver`.
