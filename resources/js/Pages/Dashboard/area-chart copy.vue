<template>


<v-card class="mx-auto">

    <Chart :size="{ width: 500, height: 420 }" :data="monthlyOrders" :margin="margin">

        <template #layers>
        <Grid strokeDasharray="2,2" />
        <Area :dataKeys="['name', 'count']" type="monotone" :areaStyle="{ fill: 'url(#grad)' }" />
        <!--<Line :dataKeys="['name', 'count']" type="monotone" :lineStyle="{stroke: '#9f7aea'}"
        />
        <Marker :value="1" label="Mean." color="green" strokeWidth="2" strokeDasharray="6 6" />
        <defs>
            <linearGradient id="grad" gradientTransform="rotate(90)">
            <stop offset="0%" stop-color="#be90ff" stop-opacity="1" />
            <stop offset="100%" stop-color="red" stop-opacity="0.4" />
            </linearGradient>
        </defs>-->
        </template>


    </Chart>

    <v-divider></v-divider>
    <v-card-title>
    {{ title }}
    </v-card-title>

    <v-card-subtitle>
    1,000 miles of wonder
    </v-card-subtitle>

    <v-card-actions>
    <v-btn color="orange-lighten-2" variant="text">
        Reports
    </v-btn>

    <v-spacer></v-spacer>

    </v-card-actions>

    <v-expand-transition>
    <div v-show="show">
        <v-divider></v-divider>

        <v-card-text class="py-0">
            <v-row align="center" no-gutters>
                <v-col class="text-h2" cols="6"> 64&deg;F</v-col>

                <v-col cols="6" class="text-right">
                <v-icon :color="color" :icon="icon" size="88"></v-icon>
                </v-col>
            </v-row>
        </v-card-text>
    </div>
    </v-expand-transition>
</v-card>

</template>

<script>
import { Chart, Grid, Line, Marker, Area } from 'vue3-charts'

export default {
    props: {
        monthlyOrders: Object,
        title: String,
        icon: String,
        color: String
    },
    components: { Chart, Grid, Line, Marker, Area },
    data () {
      return {
        show: true,
        margin:{
            left: 0,
            top: 20,
            right: 20,
            bottom: 0
            }
      }
    },
  }
  </script>
