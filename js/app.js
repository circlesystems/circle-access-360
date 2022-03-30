const apiUrl = 'https://internal.gocircle.ai/api/docs/';

var currentCircle = "";
var currentTopic = "";
var isCoreRunning = false;
var token = "";

async function getCircleToken() {
    const url = "ajax/tokengen.php";
    return fetch(url)
        .then((res) => res.json())
        .then((jsonStr) => {
            objJson = (JSON.parse(jsonStr));
            token = (objJson.Token);
            return objJson.Token;
        });
}

async function initCircle() {
   
    const isRunning = await Circle.isServiceRunning();
    if (!isRunning) {
        isCoreRunning = false;
        console.log("Circle is not running");
        return false;
    }
    const token = await getCircleToken();
    const result = await Circle.initialize(appKey, token);
    if (!result) {
        console.log("could not connect");
        return;
    }
}

async function getCircleAndTopic() {

    let allCircles;
    try {
       allCircles = await Circle.enumCircles();


    } catch (e) {
        isCoreRunning = false;
        currentCircle = "";
        currentTopic = "";
    }

    if (!isCoreRunning) {
        await connectToCircle();
        allCircles = await Circle.enumCircles();
        if (!isCoreRunning) {
            console.log("getCircleAndTopic got circle not running");
            return;
        }
    }

    if (currentCircle.length > 0 && currentTopic.length > 0) {
        return {
            CircleId: currentCircle.CircleId,
            TopicId: currentTopic.TopicId,
        };
    }

    if (!allCircles || !allCircles.Status.Result || !allCircles.CircleMeta || !allCircles.CircleMeta.length) {
        console.log("we do not have a circle, lets create one. Please, wait...");
        // we do not have a circle, lets create one
        await createCircle();
        allCircles = await Circle.enumCircles();
    }

    const firstCircle = allCircles.CircleMeta[0];

    currentCircle = firstCircle;

    const allTopics = await Circle.enumTopics(firstCircle.CircleId);
    if (!allTopics || !allTopics.Status.Result || !allTopics.Topics || !allTopics.Topics.length) {
        console.log("Cant retrieve Topic");
        return null;
    }

    const firstTopic = allTopics.Topics[0];
    currentTopic = firstTopic;

    return {
        CircleId: firstCircle.CircleId,
        TopicId: firstTopic.TopicId,
    };
}

async function createCircle() {

    if (!isCoreRunning) {
        await connectToCircle();
        if (!isCoreRunning) {
            console.log("not logged");
            return;
        }
    }
    await Circle.createCircle("auth0-demo", "");
}

async function getCircleSavedToken() {
    const circleTopicData = await getCircleAndTopic();
    if (!circleTopicData) {
        return null;
    }

    const loginToService = await Circle.logintoService(circleTopicData.CircleId, 0, "auth0-demo", "auth0-token");

    if (!loginToService || !loginToService.Status.Result || !loginToService.ServiceReturn) {
        return null;
    }

    return loginToService.ServiceReturn;
}

async function saveTokenToCircle(auth0Token) {

    const circleTopicData = await getCircleAndTopic();
    if (!circleTopicData) {
        console.log("no circleTopicData");
        return false;
    }

    const saveToken = await Circle.storeToken(circleTopicData.CircleId, 0, "auth0-token", auth0Token);

    if (saveToken && saveToken.Status.Result) {
        return true;
    }
    return false;
}


async function connectToCircle() {
    try {

        const isRunning = await Circle.isServiceRunning();
        isCoreRunning = false;
        if (!isRunning) {
            showNotConnected();
            return isCoreRunning;
        }
        const token = await getCircleToken();
        const result = await Circle.initialize(appKey, token);
        if (result && result.Status.Result) {
            isCoreRunning = true;
            console.log('Connected');
        }
        return isCoreRunning;
    } finally {

    }
}

async function checkUserIsLocked() {

    if (!isCoreRunning) {
        await connectToCircle();
        if (!isCoreRunning) {
            console.log("not logged");
            $("#loginWithCircle").prop('disabled', false);
            return;
        }
    }

    const circleTopicData = await getCircleAndTopic();
    if (!circleTopicData) {
        return null;
    }

    const userData = await Circle.whoAmI(circleTopicData.CircleId);

    if (!userData || !userData.Locked) {
        return null;
    }

}


async function getCircleValue(keyName) {

    const circleTopicData = await getCircleAndTopic();
    if (!circleTopicData) {
        return null;
    }

    if (!circleTopicData) {
        console.log("circleTopicData null");
        return null;
    }

    const added = await Circle.getValue(circleTopicData.CircleId, circleTopicData.TopicId, keyName, true);
    if (!added || !added.Status.Result) {
        return null;
    }
    return added.Value;
}

async function addCircleValue(keyName, _value) {
    if (!isCoreRunning) {
        await connectToCircle();
        if (!isCoreRunning) {
            console.log("not logged");
            return;
        }
    }

    const circleTopicData = await getCircleAndTopic();
    if (!circleTopicData) {
        //get new token and initialize
        return null;
    }
    const added = await Circle.addValue(circleTopicData.CircleId, circleTopicData.TopicId, keyName, _value);
    return (!added || added.Status.Result);
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}