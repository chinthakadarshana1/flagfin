using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Flagfin.CoreAPI.DTO
{
    public class SearchQueryDTO<Tmodel>
    {
        [JsonProperty("page_size")]
        public int PageSize { get; set; }

        [JsonProperty("page_no")]
        public int PageNo { get; set; }

        [JsonProperty("free_text")]
        public string FreeText { get; set; }

        [JsonProperty("search_model")]
        public Tmodel SearchModel { get; set; }

    }
}
