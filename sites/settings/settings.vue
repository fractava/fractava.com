<template>
    <div id="settingsContainer">
        <div id="settings">
            <div id="settingsCategories">
                <div class="settingsCategorie" v-on:click="categorie = 'general'" v-bind:class="{ active:  categorie == 'general'}">
                    <img src="sites/settings/assets/general.svg">
                    <span>{{ lang["personalSettings"] }}</span>
                </div>
                <div class="settingsCategorie" v-on:click="categorie = 'personalization'" v-bind:class="{ active:  categorie == 'personalization'}">
                    <img src="sites/settings/assets/personalization.svg">
                    <span>{{ lang["personalizationSettings"] }}</span>
                </div>
                <div class="settingsCategorie" v-on:click="categorie = 'security'" v-bind:class="{ active:  categorie == 'security'}">
                    <img src="sites/settings/assets/security.svg">
                    <span>{{ lang["securitySettings"] }}</span>
                </div>
            </div>
            <div id="settingsContent">
                <div id="generalCategorieContent" class="settingsCategorieContent" v-show="categorie == 'general'">
                    <span>{{ lang["email"] }}: </span>
                    <remoteValueInputField getDataValueName="email" getDataValues='{"getData": "user:email"}' actionValues='{"action": "user:changeEmail"}' type="email" placeholder="Email" class="inputBlack"></remoteValueInputField>
                    <span>{{ lang["firstName"] }}: </span>
                    <remoteValueInputField getDataValueName="firstName" getDataValues='{"getData": "user:firstName"}' actionValues='{"action": "user:changeFirstName"}' placeholder="Vorname" class="inputBlack"></remoteValueInputField>
                    <span>{{ lang["lastName"] }}: </span>
                    <!--<input type="text" id="lastNameSetting" v-model="lastName" placeholder="Nachname" class="inputBlack">-->
                    <remoteValueInputField getDataValueName="lastName" getDataValues='{"getData": "user:lastName"}' placeholder="Nachname" actionValues='{"action": "user:changeLastName"}' class="inputBlack"></remoteValueInputField>
                </div>
                <div class="settingsCategorieContent" v-show="categorie == 'personalization'">
                    <p>{{ lang["avatarShape"] }}:</p>
                    <p>{{ lang["avatars"] }}:</p>
                </div>
                <div class="settingsCategorieContent" v-show="categorie == 'security'">
                    <p>{{ lang["sessions"] }}:</p>
                    <p>{{ lang["changePassword"] }}:</p>
                    <p>{{ lang["deleteAccount"] }}:</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        "data": function() {
            return {
                "categorie": "general",
                "email": "test",
                "firstName": "test",
                "lastName": "test"
            };
        },
        "methods": {
        },
        "computed": {
        },
        "watch": {
        },
        "lang": {
            "en-US": {
                "email": "Email",
                "firstName": "First name",
                "lastName": "Last name",
                "avatarShape": "Avatar shape",
                "avatars": "Saved Profile Images",
                "sessions": "Logged in devices",
                "changePassword": "Change password",
                "personalSettings": "Personal",
                "deleteAccount": "Delete account",
                "personalizationSettings": "Personalization",
                "securitySettings": "Security"
            },
            "de-DE": {
                "email": "Email",
                "firstName": "Vorname",
                "lastName": "Nachname",
                "avatarShape": "Avatar Form",
                "avatars": "Gespeicherte Profilbilder",
                "sessions": "Eingeloggte Geräte",
                "changePassword": "Passwort ändern",
                "deleteAccount": "Account löschen",
                "personalSettings": "Persönlich",
                "personalizationSettings": "Personalisierung",
                "securitySettings": "Sicherheit"
            }
        }
    }
</script>

<style>
    #settingsContainer {
        background-color: black;
    }
    #settingsContainer #settings {
        width: 70%;
        margin: auto;
        padding-top: 20vh;
        font-family: timeburner;
    }
    html.phone #settingsContainer #settings {
        width: 95%;
    }
    #settingsContainer #settingsCategories {
        display: flex;
        align-items: flex-start;
        height: 15vh;
        width: 100%;
        flex-direction: row;
        flex-wrap: nowrap;
    }
    #settingsContainer .settingsCategorie {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: white;
        min-width: 10vw;
        margin-right: 15px;
    }
    #settingsContainer .settingsCategorie>img {
        height: 5vh;
    }
    #settingsContainer .settingsCategorie.active {
        border-bottom: 3px solid white;
    }
    #settingsContainer .settingsCategorieContent {
        color: white;
        display: grid;
    }
    #generalCategorieContent {
        display: grid;
        grid-template-columns: [row1-start] auto [row1-end row2-start];
        grid-template-rows: repeat(3, auto [col-start]);
    }
    #generalCategorieContent>span {
        grid-column: 1;
    }
    #generalCategorieContent>input {
        grid-column: 2
    }
</style>