const dashboardApp = new Vue({
    el: "#dashboard",
    data: {
        virtualUsers: [],
        selectedVUserIndex: -1,
        virtualDomains: [],
        selectedVDomainsIndex: -1,
        virtualAliases: [],
        selectedVAliasesIndex: -1,
        domainName: "",
        aliasName: "",
        emailName: "",
        emailPassword: "",
        domain: "",
        aliasvu: "",
        waitForResponse: false
    },
    methods: {
        selectVUser(idx) {
            this.selectedVUserIndex = idx;
        },
        selectVDomain(idx) {
            this.selectedVDomainsIndex = idx;
        },
        selectVAlias(idx) {
            this.selectedVAliasesIndex = idx;
        },
        loadVirtualUsers() {
            $.get('/virtual-users', {
                page: 0,
                size: 20
            }, null, 'json').then(r => {
                this.virtualUsers = r.data;
            }, err => {
                console.log(err);
            });
        },
        loadVirtualDomains() {
            $.get('/virtual-domains', {
                page: 0,
                size: 20
            }, null, 'json').then(r => {
                this.virtualDomains = r.data;
            }, err => {
                console.log(err);
            });
        },
        loadVirtualAliases() {
            $.get('/virtual-aliases', {
                page: 0,
                size: 20
            }, null, 'json').then(r => {
                this.virtualAliases = r.data;
            }, err => {
                console.log(err);
            });
        },
        clearEmail() {
            this.selectedVUserIndex = -1;
            this.emailName = "";
            this.domain = "";
            this.emailPassword = "";
        },
        setEmailName() {
            this.emailName = this.virtualUsers[this.selectedVUserIndex].email;
        },
        removeEmail() {
            this.waitForResponse = false;
            $.post('/virtual-users/remove', {
                id: this.virtualUsers[this.selectedVUserIndex].id
            }, null, 'json').then(r => {
                this.virtualUsers.splice(this.selectedVUserIndex, 1);
                $("#emailRemoveModal").modal('hide');
                this.clearEmail();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        addEmail() {
            this.waitForResponse = true;
            $.post('/virtual-users/add', {
                email: this.emailName,
                password: this.emailPassword,
                domain: this.virtualDomains[this.domain].id
            }, null, 'json').then(r => {
                this.virtualUsers.push(r.data);
                $("#emailModal").modal('hide');
                this.clearEmail();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        clearAlias() {
            this.selectedVAliasesIndex = -1;
            this.aliasName = "";
            this.aliasvu = "";
        },
        addAlias() {
            this.waitForResponse = true;
            $.post('/virtual-aliases/add', {
                sourceId: this.aliasvu,
                destination: this.aliasName
            }, null, 'json').then(r => {
                this.virtualAliases.push(r.data);
                $("#aliasModal").modal('hide');
                this.clearAlias();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        setAliasName() {
            this.aliasName = this.virtualAliases[this.selectedVAliasesIndex].destination;
        },
        removeAlias() {
            this.waitForResponse = false;
            $.post('/virtual-aliases/remove', {
                id: this.virtualAliases[this.selectedVAliasesIndex].id
            }, null, 'json').then(r => {
                this.virtualAliases.splice(this.selectedVAliasesIndex, 1);
                $("#aliasRemoveModal").modal('hide');
                this.clearAlias();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        addDomain() {
            this.waitForResponse = true;
            $.post('/virtual-domains/add', {
                name: this.domainName
            }, null, 'json').then(r => {
                this.virtualDomains.push(r.data);
                $("#domainModal").modal('hide');
                this.clearDomain();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        editDomain() {
            this.waitForResponse = false;
            $.post('/virtual-domains/edit', {
                id: this.virtualDomains[this.selectedVDomainsIndex].id,
                name: this.domainName
            }, null, 'json').then(r => {
                Vue.set(this.virtualDomains, this.selectedVDomainsIndex, r.data)
                $("#domainEditModal").modal('hide');
                this.clearDomain();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        removeDomain() {
            this.waitForResponse = false;
            $.post('/virtual-domains/remove', {
                id: this.virtualDomains[this.selectedVDomainsIndex].id
            }, null, 'json').then(r => {
                this.virtualDomains.splice(this.selectedVDomainsIndex, 1);
                $("#domainRemoveModal").modal('hide');
                this.clearDomain();
                this.waitForResponse = false;
            }, err => {
                console.log(err.responseJSON);
                this.waitForResponse = false;
            });
        },
        setDomainName() {
            this.domainName = this.virtualDomains[this.selectedVDomainsIndex].name;
        },
        clearDomain() {
            this.selectedVDomainsIndex = -1;
            this.domainName = "";
        },
        logout() {
            $.get('/user/logout').then(r => {
                Cookies.remove(USER_TOKEN);
                window.location.href = '/'
            });
        }
    },
    computed: {
        isVUserSelected() {
            return this.selectedVUserIndex < 0;
        },
        isVDomainSelected() {
            return this.selectedVDomainsIndex < 0;
        },
        isVAliasSelected() {
            return this.selectedVAliasesIndex < 0;
        }
    },
    created() {
        this.loadVirtualUsers();
        this.loadVirtualDomains();
        this.loadVirtualAliases();
    }
});
