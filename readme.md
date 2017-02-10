# Dashboard

This repo contains a forked version of [Spatie Dashboard package](https://github.com/spatie/dashboard.spatie.be)  

## Two Dashboards

This shows how to use two dashboards at the same time. 

* yoururl.com
* yoururl.com/sales

## New Components

* New Relic Server list
* New Relic Throughput graph
* GitLab Builds
* Wunderlist Tasks
* Bugsnag Errors
* Zoho CRM events and potentials
* Laravel News feed


### Component: New Relic Server list

Start by filled out the `NEW_RELIC_API_KEY` in the `.env` file.
By default we only show servers that are reporting. 
If you want to change this, then edit the `FetchNewRelicServerList` component.

Add `<new-relic-server grid="d1:d2"></new-relic-server>` to your blade view and you are good to go.

Each server will showcase like this:

    Server Hostname
    CPU: 1% | Mem: 6%
    IO: 0% | Disk: 34%
    
### Component: New Relic Throughput graph

Fill out the `NEW_RELIC_APP_ID` in the `.env` file.
Add `<new-relic-rpm grid="c4:d4"></new-relic-rpm>` to your blade view.

### Component: GitLab Builds

GitLab has builtin CI which in run in `Pipelines`. 
This component shows the build status of a given project. 

By design it shows the latest build from the `develop` branch. 
You can change this in the `FetchGitLabBuilds` command.

Add the following to your `.env` to install this component 

    GITLAB_URL=https://my.gitlabserver.com
    GITLAB_PRIVATE_TOKEN=1234567
    GITLAB_PROJECTS=10,11,12
    GITLAB_PROJECT_NAMES="Epic website,New App,To-Do"

### Component: Wunderlist Tasks

Jump into https://developer.wunderlist.com and create a new app and generate a access token. 

If you dont know your list_id then hit Wunderlist List API to find it, like so:

    curl --request GET \
      --url https://a.wunderlist.com/api/v1/lists \
      --header 'accept: application/json' \
      --header 'x-access-token: 1234' \
      --header 'x-client-id: abc' 

Add the following to your `.env` to install this component 

    WUNDERLIST_ACCESS_TOKEN=
    WUNDERLIST_CLIENT_ID=
    WUNDERLIST_LIST_ID=


### Component: Bugsnag Errors

This component will show opened errors (group of exceptions) from Bugsnag.

Start by getting your Data access token from the Bugsnag settings. Then find your account

    curl --request GET --url https://api.bugsnag.com/accounts/?auth_token=YOUR-TOKEN

Next find your project id

    curl --request GET --url https://api.bugsnag.com/accounts/YOUR-ACCOUNT-ID/projects?auth_token=YOUR-TOKEN

Add token and id to your `.env`

    BUGSNAG_PROJECT_ID=
    BUGSNAG_API_TOKEN=


### Component: Zoho CRM events and potentials

Visit their API docs and learn how to get your Access Token. Then add `ZOHO_TOKEN` to `.env` file.

We have 4 different events. Fell free to change them, since every sales organisation has different needs. 

    <zoho-summary-events grid="a1:a2"></zoho-summary-events>
    <zoho-newest-events grid="b1:b2"></zoho-newest-events>
    <zoho-latest-potentials grid="c1:c2"></zoho-latest-potentials>
    <zoho-won-potentials grid="d1:d2"></zoho-won-potentials>


## License

This project and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

