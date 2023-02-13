<!--suppress ALL -->
<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="FilterBy d_flex">

                <div class="FilterBy_item d_flex">
                    <h3 style="width: 70%">Joining Date:</h3>
                    <input type="date" class="form-control" ref="joining_date" name="joining_date"
                           @change="filterByDate">
                </div>


                <div class="FilterBy_item d_flex">
                    <h3 style="width: 80%">Status:</h3>
                    <div class="dropdown_part form-control">
                            <span class="dropdown-toggle d_flex" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                  aria-expanded="false">
                                <p v-text="!statusText ? 'Select Status' : statusText"></p>
                                <div class="arrow">
                                    <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.244629 0.501221L5.40989 5.66649L10.5752 0.501221H0.244629Z"
                                              fill="#747474"/>
                                    </svg>
                                </div>
                            </span>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                            <li v-for="status in statusList" @click="filterMerchants(status)"><a class="dropdown-item"
                                                                                                 href="#">{{
                                    status
                                }}</a></li>

                            <!-- up arrow -->
                            <div class="up_arrow">
                                <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.3306 5.16528L5.1653 1.6953e-05L3.48091e-05 5.16528L10.3306 5.16528Z"
                                          fill="#F3ECFF"/>
                                </svg>
                            </div>

                        </ul>

                    </div>

                </div>


                <div class="FilterBy_item">
                    <div class="custome_input">

                        <input type="text" class="form-control form-control-lg" ref="search"
                               @keyup.enter="searchMerchant" placeholder="Search here...">

                        <div class="search">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.3078 16.7113L12.6943 13.0914M14.6968 8.25366C14.6968 10.0695 13.9754 11.811 12.6914 13.095C11.4074 14.379 9.66595 15.1003 7.8501 15.1003C6.03425 15.1003 4.29277 14.379 3.00876 13.095C1.72476 11.811 1.00342 10.0695 1.00342 8.25366C1.00342 6.43781 1.72476 4.69633 3.00876 3.41233C4.29277 2.12833 6.03425 1.40698 7.8501 1.40698C9.66595 1.40698 11.4074 2.12833 12.6914 3.41233C13.9754 4.69633 14.6968 6.43781 14.6968 8.25366V8.25366Z"
                                    stroke="#A3A3A3" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>

                    </div>
                </div>

                <div class="FilterBy_item">
                    <div class="clear-filter">
                        <button class="btn btn-default mt-0" @click="clearFilter">Clear Filter</button>
                    </div>

                </div>

            </div>

        </div>
        <div class="col-lg-12">
            <div class="table_part">

                <table class="table">
                    <tbody>
                    <tr>
                        <th>SL</th>
                        <th>Company Name</th>
                        <th>Client Name</th>
                        <th>Client Contact No.</th>
                        <th>Joining Date</th>
                        <th>Next Due Date</th>
                        <th>Status</th>
                        <th>Login</th>
                        <th>Action</th>
                    </tr>

                    <tr v-for="(merchant, key) in merchants.data" :key="merchant.id">
                        <td>{{ key + 1 }}</td>
                        <td class="companyName">{{ merchant?.shop?.name }}</td>
                        <td class="name"><a :href="'/panel/merchants/'+`${merchant.id}`">{{
                                capitalized(merchant.name)
                            }}</a></td>
                        <td>{{ merchant.phone }}</td>
                        <td>{{ merchant.created_at }}</td>
                        <td></td>
                        <td>
                            <div class="dropdown_part">
                            <span class="dropdown-toggle d_flex" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                  aria-expanded="false">
                                {{ capitalized(merchant.status) }}
                                <div class="arrow">
                                    <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.244629 0.501221L5.40989 5.66649L10.5752 0.501221H0.244629Z"
                                              fill="#747474"/>
                                    </svg>
                                </div>
                            </span>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                    <li v-for="status in statusList" @click="updateStatus(merchant.id, status)"><a
                                        class="dropdown-item" id="change-status">{{ capitalized(status) }}</a></li>

                                    <!-- up arrow -->
                                    <div class="up_arrow">
                                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.3306 5.16528L5.1653 1.6953e-05L3.48091e-05 5.16528L10.3306 5.16528Z"
                                                fill="#F3ECFF"/>
                                        </svg>
                                    </div>

                                </ul>

                            </div>
                        </td>
                        <td>
                            <a href="">Login</a>
                        </td>
                        <td>
                            <a @click="deleteMerchant(merchant.id)" href="javascript:;"><i class="fa fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" :class="{disabled: currentPage === 1}"
                            @click="prevPage(merchants.prev_page_url)">
                            <a class="page-link" tabindex="-1">Previous</a>
                        </li>
                        <li v-for="pageNumber in totalPage"
                            v-if="Math.abs(pageNumber - currentPage) > 12 || pageNumber === totalPage - 1 || pageNumber === 0"
                            class="page-item" :class="{active: currentPage === pageNumber }">
                            <a class="page-link" @click="setCurrentPage(pageNumber)"
                               :class="{disabled: currentPage === pageNumber , last: (pageNumber === totalPage - 1 && Math.abs(pageNumber - currentPage) > 3), first:(pageNumber === 0 && Math.abs(pageNumber - currentPage) > 3)}">{{
                                    pageNumber
                                }}</a>
                        </li>
                        <li class="page-item" :class="{disabled: currentPage === totalPage}"
                            @click="nextPage(merchants['next_page_url'])">
                            <a class="page-link">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pageNumber: 0,
            merchants: [],
            statusList: [],
            currentPage: 1,
            totalPage: 0,
            statusText: '',
            nextPageUrl: null,
        }
    },
    mounted() {
        this.fetchMerchants();
        this.fetchStatues();
    },
    methods: {
        capitalized(name) {

            const capitalizedFirst = name[0].toUpperCase();
            const rest = name.slice(1);

            return capitalizedFirst + rest;
        },
        searchMerchant(e) {
            const search = e.target.value
            this.fetchMerchants(0, '', search)
        },
        filterByDate(e) {
            const joining_date = e.target.value
            this.fetchMerchants(0, '', '', joining_date)
        },
        fetchMerchants(page = 0, status = '', search = '', joining_date = '') {
            axios.get('/panel/merchants/merchants', {params: {page, status, search, joining_date}}).then(response => {
                this.merchants = response.data
                this.currentPage = response.data["current_page"]
                this.totalPage = response.data["last_page"]
            })
        },
        fetchStatues() {
            axios.get('/panel/merchants/statuses').then(response => {
                this.statusList = response.data
            })
        },
        filterMerchants(status) {
            this.statusText = status
            this.fetchMerchants(this.currentPage, status)
        },
        updateStatus(merchant, status) {
            axios.post('/panel/merchants/' + merchant + '/update-status', {status}).then(response => {
                this.fetchMerchants();
            })
        },

        deleteMerchant(merchant) {
            axios.post('/panel/merchants/' + merchant + '/delete').then(response => {
                this.fetchMerchants();
            })
        },
        clearFilter() {
            this.statusText = ''
            this.$refs['search'].value = ''
            this.$refs['joining_date'].value = ''
        },
        setCurrentPage(page) {
            this.currentPage = page

            this.fetchMerchants(page)
        },
        nextPage(url) {
            if (this.currentPage < this.totalPage) {
                axios.get(url).then(response => {
                    this.merchants = response.data
                    this.currentPage = response.data["current_page"]
                })
            }
        },
        prevPage(url) {
            if (this.currentPage !== 1) {
                axios.get(url).then(response => {
                    this.merchants = response.data
                    this.currentPage = response.data.current_page
                })
            }
        }
    }
}
</script>

<style>
.page-item {
    cursor: pointer;
}

.page-link, .page-link:hover {
    color: #a071f1;
}

.page-item.active .page-link {
    background-color: #a071f1 !important;
    border-color: hsl(262deg 82% 69%) !important;
}

.dropdown-menu li:hover {
    cursor: pointer;
}
</style>
