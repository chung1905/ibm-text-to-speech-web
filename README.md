# IBM Text to Speech web interface

## Preview Image
![Preview Image](https://gitlab.com/chung1905/ibm-text-to-speech-web/-/wikis/uploads/e3e130c47c8374ed33a1ec50f7e648fb/Screenshot_2021-01-18_TTS.png)

## Setup
- PHP
- Get credentials
  - Sign up IBM Cloud account: https://cloud.ibm.com/
  - Create "Text to Speech" service (free or paid): https://cloud.ibm.com/catalog/services/text-to-speech
  - Get `API Key` and `URL`
- Add credentials to environment
  - Copy `config.php.sample` to `config.php`: ```cp config.php.sample config.php```
  - Edit `API_KEY` and `API_URL` as your service
- Done
