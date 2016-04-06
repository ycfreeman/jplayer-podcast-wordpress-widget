#! /bin/bash
# See https://github.com/GaryJones/wordpress-plugin-git-flow-svn-deploy for instructions and credits.

# The way to run this is to grab this onto the root of the plugin github repo and run as a bash script from there.
# It is VERY IMPORTANT that this is run from the root of the plugin repo.

# Check for arguments
if [[ $# -ne 5 ]] ; then
    echo 'Illegal number of arguments. Please pass <Plugin Slug> <Main File> <Tag Version> <SVN Username> <SVN Password>'
    exit 1
fi

echo
echo "WordPress Plugin Git SVN Deploy v2.0.0"
echo

## Configuration

# Plugin slug name
PLUGINSLUG=$1

# Local directory where to find the git repository
PLUGINDIR=`pwd`

# Name of the main file of the plugin
MAINFILE=$2

# Git config
# This file should be the base of your git repository
GITPATH="$PLUGINDIR/"

## SVN Config
# Path to temporary svn repo
SVNPATH="$PLUGINDIR/tmp/svn/$PLUGINSLUG"
# URL of SVN repo
SVNURL="http://plugins.svn.wordpress.org/$PLUGINSLUG"
# User to use for svn repo
SVNUSER=$4
# Password to be passed when calling the script
SVNPASS=$5

TAGVERSION=$3

# Functions
# This method deletes unnecessary files and adds the ones we need
function svn_del_add {
    # Delete all files that should not to be added.
    svn status | grep -v "^.[ \t]*\..*" | grep "^\!" | awk '{print $2}' | xargs svn del
    # Add all new files that are not set to be ignored
    svn status | grep -v "^.[ \t]*\..*" | grep "^?" | awk '{print $2}' | xargs svn add
}

# Let's begin...
echo ".........................................."
echo
echo "Preparing to deploy WordPress plugin"
echo
echo ".........................................."
echo

# Check version in readme.txt is the same as plugin file after translating both to unix line breaks to work around grep's failure to identify mac line breaks
PLUGINVERSION=`grep "Version:" $GITPATH/$MAINFILE | awk -F' ' '{print $NF}' | tr -d '\r'`
echo "$MAINFILE version: $PLUGINVERSION"
READMEVERSION=`grep "^Stable tag:" $GITPATH/readme.txt | awk -F' ' '{print $NF}' | tr -d '\r'`
echo "readme.txt version: $READMEVERSION"

if [ "$READMEVERSION" = "trunk" ]; then
	echo "Version in readme.txt & $MAINFILE don't match, but Stable tag is trunk. Let's proceed..."
elif ([ "$PLUGINVERSION" != "$READMEVERSION" ] || ["$PLUGINVERSION" != "$TAGVERSION"] || ["$READMEVERSION" != "$TAGVERSION"]); then
	echo "Version in readme.txt & $MAINFILE don't match. Exiting...."
	exit 1;
elif ([ "$PLUGINVERSION" = "$READMEVERSION" ] && ["$TAGVERSION" = "$PLUGINVERSION"]); then
	echo "Versions match in readme.txt and $MAINFILE. Let's proceed..."
fi

echo
echo "Creating local copy of SVN repo trunk ..."
svn checkout --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert $SVNURL $SVNPATH --depth immediates
svn update --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert --quiet $SVNPATH/trunk --set-depth infinity

echo "Ignoring GitHub specific files"
svn propset svn:ignore "README.md
`basename "$0"`
tmp
.git
.gitignore
.svnignore
`cat $GITPATH/.svnignore`" "$SVNPATH/trunk/"

echo "Changing to $GITPATH"
cd $GITPATH

echo "Exporting the HEAD of master from git to the trunk of SVN"
git checkout-index -a -f --prefix=$SVNPATH/trunk/

# Support for the /assets folder on the .org repo.
echo "Moving assets"
# Make the directory if it doesn't already exist
mkdir -p $SVNPATH/assets/
mv $SVNPATH/trunk/wordpress-plugin-directory-assets/* $SVNPATH/assets/
svn add --force $SVNPATH/assets/
svn delete --force $SVNPATH/trunk/wordpress-plugin-directory-assets

echo "Changing directory to SVN and committing to trunk"
cd $SVNPATH/trunk/
svn_del_add
svn commit --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert -m "Preparing for $PLUGINVERSION release"

echo "Updating WordPress plugin repo assets and committing"
cd $SVNPATH/assets/
svn_del_add
svn update --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert --accept mine-full $SVNPATH/assets/*
svn commit --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert -m "Updating assets"

echo "Creating new SVN tag and committing it"
cd $SVNPATH
svn update --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert --quiet $SVNPATH/tags/$PLUGINVERSION
svn copy --quiet trunk/ tags/$PLUGINVERSION/
# Remove assets and trunk directories from tag directory
svn delete --force --quiet $SVNPATH/tags/$PLUGINVERSION/wordpress-plugin-directory-assets
svn delete --force --quiet $SVNPATH/tags/$PLUGINVERSION/trunk
cd $SVNPATH/tags/$PLUGINVERSION
svn commit --username=$SVNUSER --password=$SVNPASS --non-interactive --no-auth-cache --trust-server-cert -m "Tagging version $PLUGINVERSION"

echo "Removing temporary directory $SVNPATH"
cd $SVNPATH
cd ..
rm -fr $SVNPATH/

echo "*** FIN ***"
echo
