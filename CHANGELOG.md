# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

##### Types of changes
* [Added] for new features.
* [Changed] for changes in existing functionality.
* [Deprecated] for soon-to-be removed features.
* [Removed] for now removed features.
* [Fixed] for any bug fixes.
* [Security] in case of vulnerabilities.

## [Unreleased]
### Changed
- Customised styleci configuration
- Added funding option to project
- Changed badges in README.md


## [v2.0.0]
### Added
- New API controls for the widget to pass logged in customer data to usersnap for frontend and backend
- GeoLocation tracking deactivation option
- LocalStorage usage deactivation option
- CSP Whitelist for Usersnap resources
- Module version passed through as custom data
- Magento Deploy mode passed through as custom data

### Changed
- Frontend and Backend widgets can be controlled separately
- Updated plugin to use new widget code and API
- Support for Magento 2.4
- Admin styling now uses less instead of inline styles

### Removed
- Support for Magento 2.0, 2.1 and 2.2

### Security
- Added missing escaping to output


## [v1.2.0]
### Added
- IP Whitelisting capabilities to the module.


## [v1.1.0]
### Added
- Frontend and Backend options to turn the widget on / off in those areas 

### Updated
- Updated widget code to the latest version
- Copyright updated to remove the year
- Added optional environment option to pass to the feedback ticket
- Language files updated


## [v1.0.1]
### Updated
- Removed PHP version requirement as this should be controlled by the Magento Framework


## [v1.0.0] - 2017-05-11
### Added
- Initial release
