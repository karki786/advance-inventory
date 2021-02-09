printf "Deleting Old Folder\n"
rm -fr ../stockawesome_deploy
printf "Creating Folder\n"
mkdir ../stockawesome_deploy
printf "Creating Application Folder\n"
mkdir ../stockawesome_deploy/application
printf "Copying Public Folder\n"
cp -R public/* ../stockawesome_deploy
printf "Copying Application Folder\n"
cp -R * ../stockawesome_deploy/application
cp -R .env ../stockawesome_deploy/application
printf "Removing Redudant Folders and Files\n"
rm -fr ../stockawesome_deploy/application/public
rm -fr ../stockawesome_deploy/application/.idea
rm -fr ../stockawesome_deploy/application/.git
rm -fr ../stockawesome_deploy/application/node_modules
rm -fr ../stockawesome_deploy/application/deploy.sh
printf "Fixing Index File For you \n"
printf "Please run mklink : /D storage application\storage\app\public"
cp -fr special_files_deploy/index.php ../stockawesome_deploy
cp -fr special_files_deploy/.htaccess ../stockawesome_deploy
printf "Done \n"
printf "branch = git rev-parse --abbrev-ref HEAD"
printf 'filename = "StockAwesome_$branch"'
