# Dashboard

This repo contains a forked version of [Spatie Dashboard package](https://github.com/spatie/dashboard.spatie.be)  

## New Components

* New Relic Server list
* GitLab Builds
* Wunderlist tasks


### Component: New Relic Server list

Start by filled out the `NEW_RELIC_API_KEY` in the `.env` file.
By default we only show servers that are reporting. 
If you want to change this, then edit the `FetchNewRelicServerList` component.

Add `<new-relic-server grid="d1:d2"></new-relic-server>` to your blade view and you are good to go.

Each server will showcase like this:

    Server Hostname
    CPU: 1% | Mem: 6%
    IO: 0% | Disk: 34%

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

### Component: Wunderlist tasks

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


## License

This project and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

