const getTableSummaries = (showColumns, columns, data) => {
  const sums = []
  columns.forEach((column, index) => {
    if (index === 0) {
      sums[index] = '合计'
      return
    }
    if (showColumns.indexOf(column.property) >= 0) {
      const values = data.map(item => Number(item[column.property]))
      if (!values.every(value => isNaN(value))) {
        sums[index] = values.reduce((prev, curr) => {
          const value = Number(curr)
          if (!isNaN(value)) {
            return parseFloat(Number(prev + curr).toFixed(4))
          } else {
            return prev
          }
        }, 0);
      } else {
        sums[index] = 'N/A'
      }
    } else {
      sums[index] = ''
    }
  })

  return sums
}

export {getTableSummaries}