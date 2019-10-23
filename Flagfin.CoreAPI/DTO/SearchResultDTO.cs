using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Flagfin.CoreAPI.DTO
{
    public class SearchResultDTO<Tmodel>
    {
        [JsonProperty("page_size")]
        public int PageSize { get; set; }

        [JsonProperty("page_no")]
        public int PageNo { get; set; }

        [JsonProperty("total_records")]
        public int TotalRecords { get; set; }

        [JsonProperty("data")]
        public List<Tmodel> Data { get; set; }

    }
}
