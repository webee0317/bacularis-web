<?php
/*
 * Bacularis - Bacula web interface
 *
 * Copyright (C) 2021-2022 Marcin Haba
 *
 * The main author of Bacularis is Marcin Haba, with contributors, whose
 * full list can be found in the AUTHORS file.
 *
 * You may use this file and others of this release according to the
 * license defined in the LICENSE file, which includes the Affero General
 * Public License, v3.0 ("AGPLv3") and some additional permissions and
 * terms pursuant to its AGPLv3 Section 7.
 */

namespace Bacularis\Web\Modules;

use Bacularis\Common\Modules\ConfigFileModule;


/**
 * Manage operating system profile configuration.
 * Module is responsible for get/set OS profile config data.
 *
 * @author Marcin Haba <marcin.haba@bacula.pl>
 * @category Config
 */
class OSProfileConfig extends ConfigFileModule
{
	/**
	 * Allowed characters pattern for OS profile name.
	 */
	public const OSPROFILE_NAME_PATTERN = '[a-zA-Z0-9:.\-_ ]+';

	/**
	 * OS profile config file path
	 */
	public const CONFIG_FILE_PATH = 'Bacularis.Web.Config.osprofile';

	/**
	 * OS profile config file format
	 */
	public const CONFIG_FILE_FORMAT = 'ini';

	private const BACULARIS_REPOSITORY_ADDR = 'https://pkgs.bacularis.app';

	private const BACULARIS_REPOSITORY_KEY = self::BACULARIS_REPOSITORY_ADDR . '/bacularis.pub';

	public const REPOSITORY_TYPE_DEB = 'deb';
	public const REPOSITORY_TYPE_RPM = 'rpm';

	private const DEF_OS_PROFILES = [
		'rpm' => [
			'name' => 'RPM-based system',
			'description' => 'Profile for RHEL/CentOS/CentOS Stream/AlmaLinux/Rocky',
			'bacularis_admin_user' => 'admin',
			'bacularis_admin_pwd' => 'admin',
			'bacularis_use_https' => '1',
			'packages_use_sudo' => '1',
			'packages_sudo_user' => 'apache',
			'packages_bacularis_start' => 'systemctl start nginx',
			'packages_bacularis_install' => '/usr/bin/dnf -y install bacularis bacularis-nginx bacularis-selinux',
			'packages_bacularis_upgrade' => '/usr/bin/dnf -y update bacularis bacularis-nginx bacularis-selinux',
			'packages_bacularis_remove' => '/usr/bin/dnf -y remove bacularis bacularis-nginx bacularis-selinux',
			'packages_bacularis_info' => '/usr/bin/dnf list installed bacularis',
			'packages_bacularis_enable' => '/usr/bin/systemctl enable nginx',
			'packages_bacularis_pre_install_cmd' => '',
			'packages_bacularis_pre_upgrade_cmd' => '',
			'packages_bacularis_pre_remove_cmd' => '',
			'packages_bacularis_post_install_cmd' => '',
			'packages_bacularis_post_upgrade_cmd' => '',
			'packages_bacularis_post_remove_cmd' => '',
			'packages_dir_install' => '/usr/bin/dnf -y install bacula-director',
			'packages_dir_upgrade' => '/usr/bin/dnf -y update bacula-director',
			'packages_dir_remove' => '/usr/bin/dnf -y remove bacula-director',
			'packages_dir_info' => '/usr/bin/dnf list installed bacula-director',
			'packages_dir_enable' => '/usr/bin/systemctl enable bacula-dir',
			'packages_dir_pre_install_cmd' => '',
			'packages_dir_pre_upgrade_cmd' => '',
			'packages_dir_pre_remove_cmd' => '',
			'packages_dir_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula apache',
			'packages_dir_post_upgrade_cmd' => '',
			'packages_dir_post_remove_cmd' => '',
			'packages_sd_install' => '/usr/bin/dnf -y install bacula-storage',
			'packages_sd_upgrade' => '/usr/bin/dnf -y update bacula-storage',
			'packages_sd_remove' => '/usr/bin/dnf -y remove bacula-storage',
			'packages_sd_info' => '/usr/bin/dnf list installed bacula-storage',
			'packages_sd_enable' => '/usr/bin/systemctl enable bacula-sd',
			'packages_sd_pre_install_cmd' => '',
			'packages_sd_pre_upgrade_cmd' => '',
			'packages_sd_pre_remove_cmd' => '',
			'packages_sd_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula apache',
			'packages_sd_post_upgrade_cmd' => '',
			'packages_sd_post_remove_cmd' => '',
			'packages_fd_install' => '/usr/bin/dnf -y install bacula-client',
			'packages_fd_upgrade' => '/usr/bin/dnf -y update bacula-client',
			'packages_fd_remove' => '/usr/bin/dnf -y remove bacula-client',
			'packages_fd_info' => '/usr/bin/dnf list installed bacula-client',
			'packages_fd_enable' => '/usr/bin/systemctl enable bacula-fd',
			'packages_fd_pre_install_cmd' => '',
			'packages_fd_pre_upgrade_cmd' => '',
			'packages_fd_pre_remove_cmd' => '',
			'packages_fd_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula apache',
			'packages_fd_post_upgrade_cmd' => '',
			'packages_fd_post_remove_cmd' => '',
			'packages_bcons_install' => '/usr/bin/dnf -y install bacula-console',
			'packages_bcons_upgrade' => '/usr/bin/dnf -y update bacula-console',
			'packages_bcons_remove' => '/usr/bin/dnf -y remove bacula-console',
			'packages_bcons_info' => '/usr/bin/dnf list installed bacula-console',
			'packages_bcons_pre_install_cmd' => '',
			'packages_bcons_pre_upgrade_cmd' => '',
			'packages_bcons_pre_remove_cmd' => '',
			'packages_bcons_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula apache',
			'packages_bcons_post_upgrade_cmd' => '',
			'packages_bcons_post_remove_cmd' => '',
			'db_type' => '',
			'db_name' => '',
			'db_login' => '',
			'db_password' => '',
			'db_ip_addr' => '',
			'db_port' => '',
			'db_path' => '',
			'bconsole_use_sudo' => '1',
			'bconsole_bin_path' => '/usr/sbin/bconsole',
			'bconsole_cfg_path' => '/etc/bacula/bconsole.conf',
			'jsontools_use_sudo' => '1',
			'jsontools_bconfig_dir' => '/usr/share/bacularis/protected/vendor/bacularis/bacularis-api/API/Config',
			'jsontools_bdirjson_path' => '/usr/sbin/bdirjson',
			'jsontools_dir_cfg_path' => '/etc/bacula/bacula-dir.conf',
			'jsontools_bsdjson_path' => '/usr/sbin/bsdjson',
			'jsontools_sd_cfg_path' => '/etc/bacula/bacula-sd.conf',
			'jsontools_bfdjson_path' => '/usr/sbin/bfdjson',
			'jsontools_fd_cfg_path' => '/etc/bacula/bacula-fd.conf',
			'jsontools_bbconsjson_path' => '/usr/sbin/bbconsjson',
			'jsontools_bcons_cfg_path' => '/etc/bacula/bconsole.conf',
			'actions_use_sudo' => '1',
			'actions_dir_start' => '/usr/bin/systemctl start bacula-dir',
			'actions_dir_stop' => '/usr/bin/systemctl stop bacula-dir',
			'actions_dir_restart' => '/usr/bin/systemctl restart bacula-dir',
			'actions_sd_start' => '/usr/bin/systemctl start bacula-sd',
			'actions_sd_stop' => '/usr/bin/systemctl stop bacula-sd',
			'actions_sd_restart' => '/usr/bin/systemctl restart bacula-sd',
			'actions_fd_start' => '/usr/bin/systemctl start bacula-fd',
			'actions_fd_stop' => '/usr/bin/systemctl stop bacula-fd',
			'actions_fd_restart' => '/usr/bin/systemctl restart bacula-fd',
			'bacularis_repository_key'  => '',
			'bacularis_repository_addr'  => '',
			'bacula_use_system_repo' => '1',
			'bacula_repository_key'  => '',
			'bacula_repository_addr'  => '',
			'predefined' => true
		],
		'deb' => [
			'name' => 'DEB-based system',
			'description' => 'Profile for Debian/Ubuntu',
			'bacularis_admin_user' => 'admin',
			'bacularis_admin_pwd' => 'admin',
			'bacularis_use_https' => '1',
			'packages_use_sudo' => '1',
			'packages_sudo_user' => 'www-data',
			'packages_bacularis_start' => 'systemctl restart nginx',
			'packages_bacularis_install' => '/usr/bin/apt -y install bacularis bacularis-nginx',
			'packages_bacularis_upgrade' => '/usr/bin/apt -y install --only-upgrade bacularis bacularis-nginx',
			'packages_bacularis_remove' => '/usr/bin/apt -y remove --purge bacularis bacularis-nginx',
			'packages_bacularis_info' => '/usr/bin/dpkg -l bacularis',
			'packages_bacularis_enable' => '/usr/bin/systemctl enable nginx',
			'packages_bacularis_pre_install_cmd' => '/usr/bin/apt update',
			'packages_bacularis_pre_upgrade_cmd' => '',
			'packages_bacularis_pre_remove_cmd' => '',
			'packages_bacularis_post_install_cmd' => 'ln -sf /etc/nginx/sites-available/bacularis.conf /etc/nginx/sites-enabled/',
			'packages_bacularis_post_upgrade_cmd' => '',
			'packages_bacularis_post_remove_cmd' => '',
			'packages_dir_install' => '/usr/bin/apt -y install bacula-director',
			'packages_dir_upgrade' => '/usr/bin/apt -y install --only-upgrade bacula-director',
			'packages_dir_remove' => '/usr/bin/apt -y remove --purge bacula-director',
			'packages_dir_info' => '/usr/bin/dpkg -l bacula-director',
			'packages_dir_enable' => '/usr/bin/systemctl enable bacula-dir',
			'packages_dir_pre_install_cmd' => '',
			'packages_dir_pre_upgrade_cmd' => '',
			'packages_dir_pre_remove_cmd' => '',
			'packages_dir_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula www-data',
			'packages_dir_post_upgrade_cmd' => '',
			'packages_dir_post_remove_cmd' => '',
			'packages_sd_install' => '/usr/bin/apt -y install bacula-sd',
			'packages_sd_upgrade' => '/usr/bin/apt -y install --only-upgrade bacula-sd',
			'packages_sd_remove' => '/usr/bin/apt -y remove --purge bacula-sd',
			'packages_sd_info' => '/usr/bin/dpkg -l bacula-sd',
			'packages_sd_enable' => '/usr/bin/systemctl enable bacula-sd',
			'packages_sd_pre_install_cmd' => '',
			'packages_sd_pre_upgrade_cmd' => '',
			'packages_sd_pre_remove_cmd' => '',
			'packages_sd_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula www-data',
			'packages_sd_post_upgrade_cmd' => '',
			'packages_sd_post_remove_cmd' => '',
			'packages_fd_install' => '/usr/bin/apt -y install bacula-fd',
			'packages_fd_upgrade' => '/usr/bin/apt -y install --only-upgrade bacula-fd',
			'packages_fd_remove' => '/usr/bin/apt -y remove --purge bacula-fd',
			'packages_fd_info' => '/usr/bin/dpkg -l bacula-fd',
			'packages_fd_enable' => '/usr/bin/systemctl enable bacula-fd',
			'packages_fd_pre_install_cmd' => '',
			'packages_fd_pre_upgrade_cmd' => '',
			'packages_fd_pre_remove_cmd' => '',
			'packages_fd_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula www-data',
			'packages_fd_post_upgrade_cmd' => '',
			'packages_fd_post_remove_cmd' => '',
			'packages_bcons_install' => '/usr/bin/apt -y install bacula-console',
			'packages_bcons_upgrade' => '/usr/bin/apt -y install --only-upgrade bacula-console',
			'packages_bcons_remove' => '/usr/bin/apt -y remove --purge bacula-console',
			'packages_bcons_info' => '/usr/bin/dpkg -l bacula-console',
			'packages_bcons_pre_install_cmd' => '',
			'packages_bcons_pre_upgrade_cmd' => '',
			'packages_bcons_pre_remove_cmd' => '',
			'packages_bcons_post_install_cmd' => '/usr/share/bacularis/protected/tools/set_bacula_perm.sh /etc/bacula www-data',
			'packages_bcons_post_upgrade_cmd' => '',
			'packages_bcons_post_remove_cmd' => '',
			'db_type' => '',
			'db_name' => '',
			'db_login' => '',
			'db_password' => '',
			'db_ip_addr' => '',
			'db_port' => '',
			'db_path' => '',
			'bconsole_use_sudo' => '1',
			'bconsole_bin_path' => '/usr/sbin/bconsole',
			'bconsole_cfg_path' => '/etc/bacula/bconsole.conf',
			'jsontools_use_sudo' => '1',
			'jsontools_bconfig_dir' => '/usr/share/bacularis/protected/vendor/bacularis/bacularis-api/API/Config',
			'jsontools_bdirjson_path' => '/usr/sbin/bdirjson',
			'jsontools_dir_cfg_path' => '/etc/bacula/bacula-dir.conf',
			'jsontools_bsdjson_path' => '/usr/sbin/bsdjson',
			'jsontools_sd_cfg_path' => '/etc/bacula/bacula-sd.conf',
			'jsontools_bfdjson_path' => '/usr/sbin/bfdjson',
			'jsontools_fd_cfg_path' => '/etc/bacula/bacula-fd.conf',
			'jsontools_bbconsjson_path' => '/usr/sbin/bbconsjson',
			'jsontools_bcons_cfg_path' => '/etc/bacula/bconsole.conf',
			'actions_use_sudo' => '1',
			'actions_dir_start' => '/usr/bin/systemctl start bacula-dir',
			'actions_dir_stop' => '/usr/bin/systemctl stop bacula-dir',
			'actions_dir_restart' => '/usr/bin/systemctl restart bacula-dir',
			'actions_sd_start' => '/usr/bin/systemctl start bacula-sd',
			'actions_sd_stop' => '/usr/bin/systemctl stop bacula-sd',
			'actions_sd_restart' => '/usr/bin/systemctl restart bacula-sd',
			'actions_fd_start' => '/usr/bin/systemctl start bacula-fd',
			'actions_fd_stop' => '/usr/bin/systemctl stop bacula-fd',
			'actions_fd_restart' => '/usr/bin/systemctl restart bacula-fd',
			'bacularis_repository_key'  => '',
			'bacularis_repository_addr'  => '',
			'bacula_use_system_repo' => '1',
			'bacula_repository_key'  => '',
			'bacula_repository_addr'  => '',
			'predefined' => true
		]
	];

	private const DEF_BACULARIS_REPOSITORIES = [
		'rpm' => [
			'AlmaLinux 8' => self::BACULARIS_REPOSITORY_ADDR . '/stable/almalinux8/',
			'AlmaLinux 9' => self::BACULARIS_REPOSITORY_ADDR . '/stable/almalinux9/',
			'CentOS 8' => self::BACULARIS_REPOSITORY_ADDR . '/stable/centos8/',
			'CentOS Stream 8' => self::BACULARIS_REPOSITORY_ADDR . '/stable/centosstream8/',
			'CentOS Stream 9' => self::BACULARIS_REPOSITORY_ADDR . '/stable/centosstream9/',
			'Fedora 34' => self::BACULARIS_REPOSITORY_ADDR . '/stable/fedora34/',
			'Fedora 35' => self::BACULARIS_REPOSITORY_ADDR . '/stable/fedora35/',
			'Fedora 36' => self::BACULARIS_REPOSITORY_ADDR . '/stable/fedora36/',
			'Rocky 8' => self::BACULARIS_REPOSITORY_ADDR . '/stable/rocky8/',
			'Rocky 9' => self::BACULARIS_REPOSITORY_ADDR . '/stable/rocky9/'
		],
		'deb' => [
			'Debian 10 Buster' => self::BACULARIS_REPOSITORY_ADDR . '/stable/debian/ buster main',
			'Debian 11 Bullseye' => self::BACULARIS_REPOSITORY_ADDR . '/stable/debian/ bullseye main',
			'Ubuntu 18.04 Bionic' => self::BACULARIS_REPOSITORY_ADDR . '/stable/ubuntu/ bionic main',
			'Ubuntu 20.04 Focal' => self::BACULARIS_REPOSITORY_ADDR . '/stable/ubuntu/ focal main',
			'Ubuntu 22.04 Jammy' => self::BACULARIS_REPOSITORY_ADDR . '/stable/ubuntu/ jammy main'
		]
	];

	private const CUSTOM_OS_PROFILE_CHANGES = [
		'deb' => [
			'Debian 10 Buster' => [
				'jsontools_bdirjson_path' => '/usr/lib/bacula/bdirjson',
				'jsontools_bsdjson_path' => '/usr/lib/bacula/bsdjson',
				'jsontools_bfdjson_path' => '/usr/lib/bacula/bfdjson',
				'jsontools_bbconsjson_path' => '/usr/lib/bacula/bbconsjson',
			]
		]
	];

	/**
	 * Get pre-defined OS profile list.
	 *
	 * @return array pre-defined OS profile list
	 */
	private function getPreDefinedOSProfiles() {
		$profiles = [];
		foreach (self::DEF_BACULARIS_REPOSITORIES as $type => $repos) {
			foreach ($repos as $os => $repo) {
				$profile = self::DEF_OS_PROFILES[$type];
				$profile['name'] = $os;
				$profile['description'] = $os . ' profile';
				$profile['repository_type'] = $type;
				$profile['bacularis_repository_addr'] = $repo;
				$profile['bacularis_repository_key'] = self::BACULARIS_REPOSITORY_KEY;
				if (isset(self::CUSTOM_OS_PROFILE_CHANGES[$type][$os])) {
					// add custom changes if exist
					$profile = array_merge($profile, self::CUSTOM_OS_PROFILE_CHANGES[$type][$os]);
				}
				$profiles[$os] = $profile;
			}
		}
		return $profiles;
	}

	/**
	 * Get (read) OS profile config.
	 *
	 * @param string $section config section name
	 * @return array config
	 */
	public function getConfig($section = null, $predefined = true)
	{
		$config = $this->readConfig(
			self::CONFIG_FILE_PATH,
			self::CONFIG_FILE_FORMAT
		);

		if ($predefined) {
			// Add pre-defined profiles
			$pd_profiles = $this->getPreDefinedOsProfiles();
			$config = array_merge($pd_profiles, $config);
		}
		ksort($config);

		if ($this->validateConfig($config) === true) {
			if (!is_null($section)) {
				$config = key_exists($section, $config) ? $config[$section] : [];
			}
		} else {
			$config = [];
		}
		return $config;
	}

	/**
	 * Set (save) OS profile config.
	 *
	 * @param array $config config
	 * @return bool true if config saved successfully, otherwise false
	 */
	public function setConfig(array $config)
	{
		$result = false;
		if ($this->validateConfig($config) === true) {
			$result = $this->writeConfig(
				$config,
				self::CONFIG_FILE_PATH,
				self::CONFIG_FILE_FORMAT
			);
		}
		return $result;
	}

	/**
	 * Get single OS profile config.
	 *
	 * @param string $name OS profile name
	 * @return array OS profile config
	 */
	public function getOSProfileConfig($name)
	{
		$osprofile_config = [];
		$config = $this->getConfig();
		if (key_exists($name, $config)) {
			$osprofile_config = $config[$name];
		}
		return $osprofile_config;
	}

	/**
	 * Set single OS profile config.
	 *
	 * @param string $name OS profile name
	 * @param array $osprofile_config OS profile configuration
	 * @return bool true if config saved successfully, otherwise false
	 */
	public function setOSProfileConfig($name, array $osprofile_config)
	{
		$config = $this->getConfig(null, false);
		$config[$name] = $osprofile_config;
		return $this->setConfig($config);
	}

	/**
	 * Validate Os profile config.
	 * Config validation should be used as early as config data is available.
	 * Validation is done in read/write config methods.
	 *
	 * @access private
	 * @param array $config config
	 * @return bool true if config valid, otherwise false
	 */
	private function validateConfig(array $config = [])
	{
		return $this->isConfigValid(
			[],
			$config,
			self::CONFIG_FILE_FORMAT,
			self::CONFIG_FILE_PATH
		);
	}
}
